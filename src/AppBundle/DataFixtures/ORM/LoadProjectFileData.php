<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\BinaryFile;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadProjectFileData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $om)
    {
        $files = array(
            array('9e8b4f80-e1e1-4de3-9ccc-cfa986858be4', 'helloworld.pdf', 'application/pdf', 678, 'gaufrette.local_filesystem', 150, 150),
            array('e79c49d6-9eab-46bb-9790-5594f179f6ef', 'developer-specs-REV1_2_Public.pdf', 'application/pdf', 96085, 'gaufrette.local_filesystem', 98, 150),
        );

        $serverFilesDirectory = $this->container->getParameter('prossimo_server_files_directory');
        $currentDirectory = dirname(dirname(__FILE__)) . '/files';

        $projectRepo = $om->getRepository('AppBundle:Project');
        $userRepo = $om->getRepository('AppBundle:User');
        $project = $projectRepo->findAll()[0];
        $user = $userRepo->findAll()[0];
        foreach ($files as $file) {
            $bf = new BinaryFile();
            $bf->setUuid($file[0]);
            $bf->setFilesystemName($file[0] . '.bin');
            $bf->setHasThumbnail(true);
            $bf->setOriginalName($file[1]);
            $bf->setContentType($file[2]);
            $bf->setSize($file[3]);
            $bf->setFilesystem($file[4]);
            $bf->setThumbnailWidth($file[5]);
            $bf->setThumbnailHeight($file[6]);
            $bf->updateTimestamps();
            $bf->updateAuditFields($user);
            $project->addBinaryFile($bf);
            copy($currentDirectory . '/' . $file[0] . '.bin', $serverFilesDirectory . '/' . $file[0] . '.bin');
            copy($currentDirectory . '/' . $file[0] . '-thumbnail.bin', $serverFilesDirectory . '/' . $file[0] . '-thumbnail.bin');
        }
        $om->persist($project);
        $om->flush();
    }

    public function getOrder()
    {
        return 30;
    }
}
