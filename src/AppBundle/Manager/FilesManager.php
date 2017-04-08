<?php
namespace AppBundle\Manager;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Doctrine\ORM\EntityManager;

use Gaufrette\Exception\FileNotFound;
use Gaufrette\Filesystem;

use GuzzleHttp\ClientInterface;

use AppBundle\Entity\BinaryFile;
use AppBundle\Entity\Project;
use AppBundle\Entity\User;
use AppBundle\Helpers\StringHelper;

class FilesManager extends ContainerAware
{
    CONST BINARY_EXTENSION = '.bin';
    CONST METADATA_EXTENSION = '.meta';

    /** @var EntityManager $em */
    protected $em;

    /** @var Filesystem $tempFS */
    protected $tempFS;

    /** @var Filesystem $localFS */
    protected $localFS;

    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->em = $this->container->get('doctrine.orm.entity_manager');
        $this->tempFS = $this->container->get('gaufrette.temp_filesystem');
        $this->localFS = $this->container->get('gaufrette.local_filesystem');
    }

    /**
     * Move file from Temp to Local filesystem
     *
     * @param string $key Filename to move
     */
    public function moveFileFromTempToLocal($key)
    {
        if ($this->tempFS->has($key)) {
            // Read content from Temp
            $content = $this->tempFS->read($key);
            // Write content to Local
            $this->localFS->write($key, $content);
        } else throw new FileNotFound($key);
    }

    /**
     * Move file from Temp to Local filesystem
     *
     * @param string $key
     */
    public function moveFileFromLocalToTemp($key)
    {
        if ($this->localFS->has($key)) {
            // Read content from Local
            $content = $this->localFS->read($key);
            // Write content to Temp
            $this->tempFS->write($key, $content);
            $this->localFS->delete($key);
        } else throw new FileNotFound($key);
    }

    /**
     * Get list of files stored in Temp directory
     *
     * @return array
     */
    public function getAllFilesFromTemp()
    {
        $serializer = $this->container->get('jms_serializer');
        $fileKeys = $this->tempFS->keys();

        $result = [];
        foreach ($fileKeys as $item) {
            if (!$this->tempFS->isDirectory($item)) {
                if (StringHelper::endsWith($item, self::METADATA_EXTENSION)) {

                    $content = $this->tempFS->read($item);
                    $fileMetadata = $serializer->deserialize($content, 'AppBundle\Entity\BinaryFile', 'json');
                    $result[] = $fileMetadata;
                }
            }
        }

        return $result;
    }

    /**
     * Clear Temp directory from all files older than $keep_age
     *
     * @param int $keep_age File age in seconds to keep in temp dir (skip remove)
     */
    public function clearTempDirectory($keep_age = 600)
    {
        $currentDateTime = new \DateTime("now");
        $currentTimestamp = $currentDateTime->getTimestamp();
        $fileKeys = $this->tempFS->keys();
        $serializer = $this->container->get('jms_serializer');

        $filesToRemove = [];
        foreach ($fileKeys as $item) {
            if (!$this->tempFS->isDirectory($item)) {
                if (StringHelper::endsWith($item, 'meta')) {
                    $content = $this->tempFS->read($item);
                    $fileMetadata = $serializer->deserialize($content, 'AppBundle\Entity\BinaryFile', 'json');
                    $createdTimestamp = $fileMetadata->getCreatedAt()->getTimestamp();
                    $fileAgeSeconds = abs($currentTimestamp - $createdTimestamp);
                    if ($fileAgeSeconds > $keep_age) {
                        $filesToRemove[] = $item; // add metadata to delete list
                        $filesToRemove[] = $fileMetadata->getFilesystemName(); // add binary to delete list
                    }
                }
            }
        }

        foreach ($filesToRemove as $item)
            $this->tempFS->delete($item);
    }

    /**
     * Delete binary file from Temp directory
     *
     * @param string $key Filename to delete
     */
    public function deleteTempFileBinaryData($key)
    {
        $this->tempFS->delete($key);
    }

    /**
     * Delete binary file from Local directory
     *
     * @param string $key Filename to delete
     */
    public function deleteLocalFileBinaryData($key)
    {
        $this->localFS->delete($key);
    }

    /**
     * Link BinaryFile to Project
     *
     * @param BinaryFile $binaryFile
     * @param Project $project
     */
    public function linkFileToProject(BinaryFile $binaryFile, Project $project)
    {
        $project->addBinaryFile($binaryFile);
        $this->em->flush($project);
    }

    /**
     * Link Temporary BinaryFile to Project
     * Move file from temp filesystem (preloaded file) to local filesystem
     * and update DB link.
     *
     * @param string $fileUuid
     * @param Project $project
     */
    public function linkTempFileToProject($fileUuid, Project $project)
    {
        $filename = $fileUuid . FilesManager::BINARY_EXTENSION;
        $filemeta = $fileUuid . FilesManager::METADATA_EXTENSION;
        $filethumbnail = $fileUuid . '-thumbnail' . FilesManager::BINARY_EXTENSION;

        $this->moveFileFromTempToLocal($filename);
        //move thumbnail if exists
        $this->tempFS->has($filethumbnail) ? $this->moveFileFromTempToLocal($filethumbnail) : null;

        // Deserialize Metadata to BinaryFile object
        $serializer = $this->container->get('jms_serializer');
        $content = $this->tempFS->read($filemeta);

        /** @var BinaryFile $fileMetadata */
        $fileMetadata = $serializer->deserialize($content, 'AppBundle\Entity\BinaryFile', 'json');
        $fileMetadata->setFilesystem('gaufrette.local_filesystem');

        /** @var User $createdByDeserializedUser */
        $createdByDeserializedUser = $fileMetadata->getCreatedBy();
        /** @var User $updatedByDeserializedUser */
        $updatedByDeserializedUser = $fileMetadata->getUpdatedBy();

        $userRepo = $this->em->getRepository('AppBundle:User');
        $createdDbUser = $userRepo->find($createdByDeserializedUser->getId());
        $updatedDbUser = $userRepo->find($updatedByDeserializedUser->getId());

        $fileMetadata->setCreatedBy($createdDbUser);
        $fileMetadata->setUpdatedBy($updatedDbUser);

        // Append to Project
        $this->linkFileToProject($fileMetadata, $project);

        // Clear temp
        $this->tempFS->delete($filename);
        $this->tempFS->delete($filemeta);
        $this->tempFS->has($filethumbnail) ? $this->tempFS->delete($filethumbnail) : null;
    }

    /**
     * Detach and move Project File back to temporary filesystem
     *
     * @param BinaryFile $binaryFile
     * @param Project    $project
     */
    public function unlinkProjectFile(BinaryFile $binaryFile, Project $project)
    {
        $binaryFile->setFilesystem('gaufrette.temp_filesystem');
        $filename = $binaryFile->getFilesystemName();

        try {
            $this->moveFileFromLocalToTemp($filename);
            $this->tempFS->write(
                $binaryFile->getUuid() . FilesManager::METADATA_EXTENSION,
                $this->getMetadata($binaryFile)
            );
        } catch (FileNotFound $e) {}

        if ($binaryFile->getThumbnail()) {
            try {
                $this->moveFileFromLocalToTemp($binaryFile->getThumbnail() . FilesManager::BINARY_EXTENSION);
            } catch (FileNotFound $e) {}
        }

        $project->removeBinaryFile($binaryFile);
        $this->em->remove($binaryFile);
        $this->em->flush([$project, $binaryFile]);
    }

    /**
     * Link BinaryFile to User
     *
     * @param BinaryFile $binaryFile
     * @param User $user
     */
    public function linkFileToUser(BinaryFile $binaryFile, User $user)
    {
        $user->addBinaryFile($binaryFile);
        $this->em->flush($user);
    }

    /**
     * Link Temporary BinaryFile to User
     * Move file from temp filesystem (preloaded file) to local filesystem
     * and update DB link.
     *
     * @param string $fileUuid
     * @param User $user
     */
    public function linkTempFileToUser($fileUuid, User $user)
    {

        $filename = $fileUuid . FilesManager::BINARY_EXTENSION;
        $filemeta = $fileUuid . FilesManager::METADATA_EXTENSION;
        $filethumbnail = $fileUuid . '-thumbnail' . FilesManager::BINARY_EXTENSION;

        $this->moveFileFromTempToLocal($filename);
        //move thumbnail if exists
        $this->tempFS->has($filethumbnail) ? $this->moveFileFromTempToLocal($filethumbnail) : null;

        // Deserialize Metadata to BinaryFile object
        $serializer = $this->container->get('jms_serializer');
        $content = $this->tempFS->read($filemeta);

        /** @var BinaryFile $fileMetadata */
        $fileMetadata = $serializer->deserialize($content, 'AppBundle\Entity\BinaryFile', 'json');
        $fileMetadata->setFilesystem('gaufrette.local_filesystem');

        /** @var User $createdByDeserializedUser */
        $createdByDeserializedUser = $fileMetadata->getCreatedBy();
        /** @var User $updatedByDeserializedUser */
        $updatedByDeserializedUser = $fileMetadata->getUpdatedBy();

        $userRepo = $this->em->getRepository('AppBundle:User');
        $createdDbUser = $userRepo->find($createdByDeserializedUser->getId());
        $updatedDbUser = $userRepo->find($updatedByDeserializedUser->getId());

        $fileMetadata->setCreatedBy($createdDbUser);
        $fileMetadata->setUpdatedBy($updatedDbUser);

        // Append to User
        $this->linkFileToUser($fileMetadata, $user);

        // Clear temp
        $this->tempFS->delete($filename);
        $this->tempFS->delete($filemeta);
        $this->tempFS->has($filethumbnail) ? $this->tempFS->delete($filethumbnail) : null;
    }

    // Dependencies

    public function getFileDependencies(BinaryFile $binaryFile)
    {
        $result = [];
        $users = $this->getFileLinkedUsers($binaryFile);
        if ($users) {
            $result["users"] = $users;
        }
        $projects = $this->getFileLinkedProjects($binaryFile);
        if ($projects) {
            $result["projects"] = $projects;
        }

        return $result;
    }

    public function getFileLinkedUsers(BinaryFile $binaryFile)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('u')
            ->from('AppBundle:User', 'u')
            ->innerJoin('u.binaryFiles', 'bf')
            ->where('bf = :file')
            ->setParameter('file', $binaryFile);

        $users = $qb->getQuery()->getResult();

        return $users;
    }

    public function getFileLinkedProjects(BinaryFile $binaryFile)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('p')
            ->from('AppBundle:Project', 'p')
            ->innerJoin('p.binaryFiles', 'bf')
            ->where('bf = :file')
            ->setParameter('file', $binaryFile);

        $projects = $qb->getQuery()->getResult();

        return $projects;
    }

    public function downloadFromUrl($url, array $headers = [])
    {
        $response = $this->httpClient->request('GET', $url, ['headers' => $headers]);

        $tempFile = tempnam(sys_get_temp_dir(), 'PROS_TMP_FILE_');

        if (file_put_contents($tempFile, $response->getBody()) === false) {
            throw new \Exception('Could not write to temporary file');
        }

        return $tempFile;
    }

    /**
     * @param  BinaryFile $binaryFile
     * @return string
     */
    private function getMetadata(BinaryFile $binaryFile)
    {
        $bf = new BinaryFile();
        $bf->setUuid($binaryFile->getUuid());
        $bf->setOriginalName($binaryFile->getOriginalName());
        $bf->setFilesystemName($binaryFile->getFilesystemName());
        $bf->setContentType($binaryFile->getContentType());
        $bf->setSize($binaryFile->getSize());
        $bf->setFilesystem($binaryFile->getFilesystem());
        $bf->setCreatedAt($binaryFile->getCreatedAt());
        $bf->updateTimestamps();
        $bf->setCreatedBy($binaryFile->getCreatedBy());
        $bf->setUpdatedBy($binaryFile->getUpdatedBy());

        $serializer = $this->container->get('jms_serializer');
        return $serializer->serialize($bf, 'json');
    }
}
