<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Quote;

/**
 * Class LoadQuoteData
 */
class LoadQuoteData extends AbstractFixture  implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= 2; $i++) {
            $q = new Quote();
            $q->setProject($this->getReference('project_' . $i));
            $q->setIsDefault(true);

            $manager->persist($q);

            $this->addReference('quote_' . $i, $q);
        }

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 21;
    }
}
