<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\BinaryFile;
use AppBundle\Helpers\StringHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class BinaryFileRepository extends EntityRepository implements ContainerAwareInterface
{
    /*
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getAllFilesFromTemp() {
        $filesystem = $this->container->get('gaufrette.temp_filesystem');
        $serializer = $this->container->get('jms_serializer');

        $filenames = $filesystem->keys();

        $result = [];
        foreach ($filenames as $item) {
            if (!$filesystem->isDirectory($item)) {
                if (StringHelper::endsWith($item,'meta')) {

                    $content = $filesystem->read($item);
                    $fileMetadata = $serializer->deserialize($content, 'AppBundle\Entity\BinaryFile', 'json');
                    $result[] = $fileMetadata;
                }
            }
        }

        return $result;
    }

}