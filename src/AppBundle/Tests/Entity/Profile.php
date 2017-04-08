<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Dictionary;
use AppBundle\Entity\DictionaryEntry;
use AppBundle\Entity\Profile;
use AppBundle\Entity\Unit;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProfileTest extends KernelTestCase {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
    }

    public function testProfileUnits(){

        $profile = new Profile();
        $profile->setName("MyTestProfile");

        $unit = new Unit();
        $unit->setDescription("MyTestUnit1");

        $profile->addUnit($unit);

        $this->em->persist($profile);
        $this->em->flush();

        $unitID = $unit->getId();

        // Unit, loaded from DB must have profile property
        $storedUnit = $this->em->find("AppBundle:Unit", $unitID);
        $this->assertNotNull($storedUnit->getProfile());

        // Remove Profile. Unit must remain in DB, but must has NO profile:
        $this->em->remove($profile);
        $this->em->flush();
        $this->em->clear();

        $storedUnit = $this->em->find("AppBundle:Unit", $unitID);
        $this->assertNull($storedUnit->getProfile());
    }

    public function testProfileDictionary()
    {
        $profile = new Profile();
        $profile->setName("Main actors");

        $dict = new Dictionary();
        $dict->setName("Matrix Movie Actors");

        $entries = [
            new DictionaryEntry(),
            new DictionaryEntry(),
            new DictionaryEntry()
        ];
        $entries[0]->setName('Keanu Reeves');
        $entries[1]->setName('Gloria Foster');
        $entries[2]->setName('Hugo Weaving');
        $dict->addEntry($entries[0]);
        $dict->addEntry($entries[1]);
        $dict->addEntry($entries[2]);

        $this->em->persist($dict);
        $this->em->persist($profile);

        $profile->addDictionaryEntry($entries[0]);
        $profile->addDictionaryEntry($entries[2]);

        $this->em->persist($profile);
        $this->em->flush();
        $this->em->clear();

        /* @var $profile Profile */
        $profile = $this->em->find("AppBundle:Profile", $profile->getId());

        $this->assertNotEmpty($profile);
        $this->assertCount(2, $profile->getDictionaryEntries());

        $this->em->remove($profile);
        $this->em->remove($dict);
    }

}