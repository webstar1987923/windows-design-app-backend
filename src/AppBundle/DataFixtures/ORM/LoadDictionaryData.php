<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Dictionary;
use AppBundle\Entity\DictionaryEntry;
use AppBundle\Entity\DictionaryEntryProfile;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadDictionaryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $om)
    {
        $dictionariesData = array(
            array('Interior Handle', '', Dictionary::PRICING_SCHEME_PER_ITEM, 0),
            array('Exterior Handle', '', Dictionary::PRICING_SCHEME_NONE, 1),
            array('Interior Finish', '', Dictionary::PRICING_SCHEME_PRICING_GRIDS, 2),
        );

        $entriesData = [
            [
                ['Brass Metal-W/Lock + Key', 0],
                ['Brown Plastic-W/Lock + Key', 1]
            ],
            [
                ['White Plastic-No Lock', 0],
                ['Brushed Silver Metal-W/Lock + Key', 1]
            ],
            [
                ['White', 0],
                ['Clear Lacquer', 1],
            ]
        ];

        $gridsData = [
            '[{"name":"fixed","data":[{"height":500,"width":500,"value":15},{"height":914,"width":1514,"value":14},{"height":2400,"width":3000,"value":11}]},{"name":"operable","data":[{"height":500,"width":500,"value":13},{"height":914,"width":1514,"value":12},{"height":1200,"width":2400,"value":10}]}]'
        ];

        $equationParamsData = [
            '[{"name":"fixed","param_a":11,"param_b":39},{"name":"operable","param_a":9,"param_b":62}]'
        ];

        foreach ($dictionariesData as $key => $item) {
            $dictionary = new Dictionary();
            $dictionary->setName($item[0]);
            $dictionary->setRulesAndRestrictions($item[1]);
            $dictionary->setPricingScheme($item[2]);
            $dictionary->setPosition($item[3]);
            $flag = false;

            foreach ($entriesData[$key] as $ed) {
                $entry = new DictionaryEntry();
                $entry->setName($ed[0]);
                $entry->setPosition($ed[1]);

                $ep = new DictionaryEntryProfile();
                $ep->setEntry($entry);
                $ep->setProfile($om->getRepository('AppBundle:Profile')->findOneBy(array('id' => 1)));
                $om->persist($ep);

                if ( $dictionary->getPricingScheme() === Dictionary::PRICING_SCHEME_PER_ITEM ) {
                    $ep->setCostPerItem(15);
                } else if (
                    $dictionary->getPricingScheme() === Dictionary::PRICING_SCHEME_LINEAR_EQUATION ||
                    $dictionary->getPricingScheme() === Dictionary::PRICING_SCHEME_PRICING_GRIDS
                ) {
                    $ep->setPricingGrids($gridsData[0]);
                    $ep->setPricingEquationParams($equationParamsData[0]);
                }

                if ($flag) {
                    $ep1 = new DictionaryEntryProfile();
                    $ep1->setEntry($entry);
                    $ep1->setProfile($om->getRepository('AppBundle:Profile')->findOneBy(array('id' => 2)));
                    $om->persist($ep1);

                    if ( $dictionary->getPricingScheme() === Dictionary::PRICING_SCHEME_PER_ITEM ) {
                        $ep1->setCostPerItem(15);
                    } else if (
                        $dictionary->getPricingScheme() === Dictionary::PRICING_SCHEME_LINEAR_EQUATION ||
                        $dictionary->getPricingScheme() === Dictionary::PRICING_SCHEME_PRICING_GRIDS
                    ) {
                        $ep1->setPricingGrids($gridsData[0]);
                        $ep1->setPricingEquationParams($equationParamsData[0]);
                    }

                    $ep2 = new DictionaryEntryProfile();
                    $ep2->setEntry($entry);
                    $ep2->setProfile($om->getRepository('AppBundle:Profile')->findOneBy(array('id' => 3)));
                    $om->persist($ep2);

                    if ( $dictionary->getPricingScheme() === Dictionary::PRICING_SCHEME_PER_ITEM ) {
                        $ep2->setCostPerItem(15);
                    } else if (
                        $dictionary->getPricingScheme() === Dictionary::PRICING_SCHEME_LINEAR_EQUATION ||
                        $dictionary->getPricingScheme() === Dictionary::PRICING_SCHEME_PRICING_GRIDS
                    ) {
                        $ep2->setPricingGrids($gridsData[0]);
                        $ep2->setPricingEquationParams($equationParamsData[0]);
                    }
                }
                $dictionary->addEntry($entry);
                $flag = true;
            }
            $om->persist($dictionary);
            $om->flush();
        }
    }

    public function getOrder()
    {
        return 26;
    }
}