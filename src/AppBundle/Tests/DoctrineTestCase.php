<?php

namespace AppBundle\Tests;

use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class DoctrineTestCase extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager('sqlite')
        ;

        //create schema
        $schema = array_map(function ($class) {
            return $this->em->getClassMetadata($class);
        }, $this->getTestedEntities() );

        $schemaTool = new SchemaTool($this->em);
        $schemaTool->dropSchema($schema);
        $schemaTool->createSchema($schema);
    }

    abstract protected function getTestedEntities();

    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
    }

}
