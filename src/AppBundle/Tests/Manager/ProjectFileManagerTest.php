<?php

namespace AppBundle\Tests\Manager;

use Symfony\Component\Security\Core\Util\SecureRandom;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Gaufrette\Exception\FileNotFound;

use JMS\Serializer\SerializationContext;

use AppBundle\Manager\ProjectFileManager;
use AppBundle\Manager\FilesManager;
use AppBundle\Entity\Project;
use AppBundle\Entity\BinaryFile;
use AppBundle\Entity\User;
use AppBundle\Helpers\UuidHelper;

/**
 * Class ProjectFileManagerTest
 */
class ProjectFileManagerTest extends KernelTestCase
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * setUp
     */
    protected function setUp()
    {
        self::bootKernel();
        $this->container = static::$kernel->getContainer();
    }

    public function testUpdateCreatesProjectFiles()
    {
        $container = static::$kernel->getContainer();
        $em = $container->get('doctrine.orm.default_entity_manager');

        $project = new Project();

        $em->persist($project);
        $em->flush();

        $fileUuids = [$this->createTestFile()->getUuid()];

        $pfm = new ProjectFileManager($container->get('app.manager.files'), $em);
        $pfm->updateProjectFiles($project, $fileUuids);

        $project = $em->getRepository('AppBundle:Project')->find($project->getId());

        $this->assertNotEmpty($project->getBinaryFiles());

        $em->remove($project);
        $em->flush();

        $this->removeTestFile($fileUuids[0]);
    }

    public function testUpdateRemovesProjectFiles()
    {
        $container = static::$kernel->getContainer();
        $em = $container->get('doctrine.orm.default_entity_manager');
        $fileManager = $container->get('app.manager.files');

        $project = new Project();

        $em->persist($project);

        $file = $this->createTestFile();
        $fileManager->linkTempFileToProject($file->getUuid(), $project);

        $em->flush();

        $pfm = new ProjectFileManager($fileManager, $em);
        $pfm->updateProjectFiles($project, []);

        $project = $em->getRepository('AppBundle:Project')->find($project->getId());

        $this->assertEmpty($project->getBinaryFiles());

        $tempFs = $container->get('gaufrette.temp_filesystem');
        $this->assertTrue($tempFs->has($file->getUuid() . FilesManager::BINARY_EXTENSION));
        $this->assertTrue($tempFs->has($file->getUuid() . FilesManager::METADATA_EXTENSION));
        $this->assertFalse($project->getBinaryFiles()->contains($file));

        $localFs = $container->get('gaufrette.local_filesystem');
        $this->assertFalse($localFs->has($file->getUuid() . FilesManager::BINARY_EXTENSION));

        $em->remove($project);
        $em->flush();

        $this->removeTestFile($file->getUuid());
    }

    public function testUpdateCreatesAndRemovesProjectFiles()
    {
        $container = static::$kernel->getContainer();
        $em = $container->get('doctrine.orm.default_entity_manager');
        $fileManager = $container->get('app.manager.files');

        $project = new Project();

        $em->persist($project);

        $createdFile = $this->createTestFile();
        $deletedFile = $this->createTestFile();

        // link a file to the project
        $fileManager->linkTempFileToProject($deletedFile->getUuid(), $project);

        $em->flush();

        $pfm = new ProjectFileManager($fileManager, $em);
        // update project files
        // this should link a new file (createdFile)
        // and unattach the existing file (deletedFile)
        // "deletedFile" should get moved to the temporary filesystem
        $pfm->updateProjectFiles($project, [$createdFile->getUuid()]);

        $project = $em->getRepository('AppBundle:Project')->find($project->getId());

        $this->assertNotEmpty($project->getBinaryFiles());

        // test that the new file is linked
        $this->assertTrue($project->getBinaryFiles()->exists(function($key, BinaryFile $el) use ($createdFile){
            return ($el->getUuid() === $createdFile->getUuid());
        }));

        // test that the file to be deleted is no longer linked
        $this->assertFalse($project->getBinaryFiles()->exists(function($key, BinaryFile $el) use ($deletedFile){
            return ($el->getUuid() === $deletedFile->getUuid());
        }));

        // test that the deleted file now resides in the temporary filesystem
        $tempFs = $container->get('gaufrette.temp_filesystem');
        $this->assertTrue($tempFs->has($deletedFile->getUuid() . FilesManager::BINARY_EXTENSION));
        $this->assertTrue($tempFs->has($deletedFile->getUuid() . FilesManager::METADATA_EXTENSION));

        // test that the deleted file is no longer in the local filesystem
        $localFs = $container->get('gaufrette.local_filesystem');
        $this->assertFalse($localFs->has($deletedFile->getUuid() . FilesManager::BINARY_EXTENSION));

        $em->remove($project);
        $em->flush();

        $this->removeTestFile($createdFile->getUuid());
        $this->removeTestFile($deletedFile->getUuid());
    }

    public function testUpdateWithEmptyDataDoesNothing()
    {
        $container = static::$kernel->getContainer();
        $em = $container->get('doctrine.orm.default_entity_manager');

        $project = new Project();

        $em->persist($project);
        $em->flush();

        $pfm = new ProjectFileManager($container->get('app.manager.files'), $em);
        $pfm->updateProjectFiles($project, []);

        $project = $em->getRepository('AppBundle:Project')->find($project->getId());

        $this->assertEmpty($project->getBinaryFiles());

        $em->remove($project);
        $em->flush();
    }

    public function testUpdateCreateWithOneExisting()
    {
        $container = static::$kernel->getContainer();
        $em = $container->get('doctrine.orm.default_entity_manager');
        $fileManager = $container->get('app.manager.files');

        $project = new Project();

        $em->persist($project);

        $createdFile = $this->createTestFile();
        $existingFile = $this->createTestFile();

        // link a file to the project
        $fileManager->linkTempFileToProject($existingFile->getUuid(), $project);

        $em->flush();

        $pfm = new ProjectFileManager($fileManager, $em);
        // update project files
        // this should link a new file (createdFile)
        // and leave the existing file (existingFile)
        $pfm->updateProjectFiles($project, [$createdFile->getUuid(), $existingFile->getUuid()]);

        $project = $em->getRepository('AppBundle:Project')->find($project->getId());

        $this->assertNotEmpty($project->getBinaryFiles());

        // test that the new file is linked
        $this->assertTrue($project->getBinaryFiles()->exists(function($key, BinaryFile $el) use ($createdFile){
            return ($el->getUuid() === $createdFile->getUuid());
        }));

        // test that the existing file is still linked
        $this->assertTrue($project->getBinaryFiles()->exists(function($key, BinaryFile $el) use ($existingFile){
            return ($el->getUuid() === $existingFile->getUuid());
        }));

        // test that both files are now in the local filesystem
        $localFs = $container->get('gaufrette.local_filesystem');
        $this->assertTrue($localFs->has($createdFile->getUuid() . FilesManager::BINARY_EXTENSION));
        $this->assertTrue($localFs->has($existingFile->getUuid() . FilesManager::BINARY_EXTENSION));

        // ... and not in the temporary filesystem
        $tempFs = $container->get('gaufrette.temp_filesystem');
        $this->assertFalse($tempFs->has($createdFile->getUuid() . FilesManager::BINARY_EXTENSION));
        $this->assertFalse($tempFs->has($existingFile->getUuid() . FilesManager::BINARY_EXTENSION));

        $em->remove($project);
        $em->flush();

        $this->removeTestFile($createdFile->getUuid());
        $this->removeTestFile($existingFile->getUuid());
    }

    public function testMissingFilesAreIgnored()
    {
        $container = static::$kernel->getContainer();
        $em = $container->get('doctrine.orm.default_entity_manager');

        $bf = $this->createBinaryFile();
        $project = new Project();
        $project->addBinaryFile($bf);

        $em->persist($project);
        $em->flush();

        $pfm = new ProjectFileManager($container->get('app.manager.files'), $em);
        $pfm->updateProjectFiles($project, []);

        $project = $em->getRepository('AppBundle:Project')->find($project->getId());

        $this->assertEmpty($project->getBinaryFiles());

        $em->remove($project);
        $em->flush();
    }

    public function testUnlinkingProjectFileWithMissingFileDoesntCreateTempMetaFile()
    {
        $container = static::$kernel->getContainer();
        $em = $container->get('doctrine.orm.default_entity_manager');

        $bf = $this->createBinaryFile();
        $project = new Project();
        $project->addBinaryFile($bf);

        $em->persist($project);
        $em->flush();

        $pfm = new ProjectFileManager($container->get('app.manager.files'), $em);
        $pfm->updateProjectFiles($project, []);

        // ... and not in the temporary filesystem
        $tempFs = $container->get('gaufrette.temp_filesystem');
        $this->assertFalse($tempFs->has($bf->getUuid() . FilesManager::METADATA_EXTENSION));

        $em->remove($project);
        $em->flush();
    }

    private function createTestFile()
    {
        $container = static::$kernel->getContainer();

        $bf = $this->createBinaryFile();

        $filesystem = $container->get('gaufrette.temp_filesystem');
        $serializer = $container->get('jms_serializer');

        $filemeta = $bf->getUuid() . FilesManager::METADATA_EXTENSION;
        $content = (new SecureRandom())->nextBytes(32);

        $filesystem->write($bf->getFilesystemName(), $content);

        $filesystem->write(
            $filemeta,
            $serializer->serialize($bf, 'json', SerializationContext::create()->setGroups(['Default', 'files-metadata']))
        );

        return $bf;
    }

    private function removeTestFile($uuid)
    {
        $container = static::$kernel->getContainer();
        $filesystem = $container->get('gaufrette.temp_filesystem');

        try {
            $files = [
                $uuid . FilesManager::BINARY_EXTENSION,
                $uuid . FilesManager::METADATA_EXTENSION,
            ];

            foreach ($files as $file) {
                $filesystem->delete($file);
            }
        } catch (FileNotFound $e) {}
    }

    private function createBinaryFile()
    {
        $container = static::$kernel->getContainer();
        $em = $container->get('doctrine.orm.default_entity_manager');

        $user = $em->getRepository('AppBundle:User')->findAll()[0];

        $uuid = UuidHelper::NewUuid();

        $filename = $uuid . FilesManager::BINARY_EXTENSION;

        $bf = new BinaryFile();
        $bf->setUuid($uuid);
        $bf->setOriginalName($filename);
        $bf->setFilesystemName($filename);
        $bf->setContentType('application/octet-stream');
        $bf->setSize(32);
        $bf->setFilesystem('gaufrette.temp_filesystem');
        $bf->updateTimestamps();
        $bf->updateAuditFields($user);

        return $bf;
    }
}
