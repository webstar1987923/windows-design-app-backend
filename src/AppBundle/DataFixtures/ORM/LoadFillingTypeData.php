<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\FillingType;
use AppBundle\Entity\FillingTypeProfile;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadFillingTypeData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $om)
    {
        //  [Prossimo Name, Supplier Name, Type, Weight per Area, Position]
        $fillingTypesData = array(
            array(
                'Triple Glazed Low-e:  U=.11 SHGC=.5 VT=.71',
                'Triple Glazed Ug=0.6 4T/16AR/4/16AR/4T',
                'glass',
                1.5,
                FillingType::PRICING_SCHEME_PRICING_GRIDS,
                0,
            ),
            array(
                'Economy Triple Glazed',
                '4LE/10AR/4/10AR/4LE',
                'glass',
                1.4,
                FillingType::PRICING_SCHEME_PRICING_GRIDS,
                1,
            ),
            array(
                'Insulated PVC Panel',
                'Insulated PVC Panel',
                'recessed',
                1.14,
                FillingType::PRICING_SCHEME_PRICING_GRIDS,
                2,
            ),
        );

        $pricingGridsData = [
            '[{"name":"fixed","data":[{"height":500,"width":500,"value":15},{"height":914,"width":1514,"value":12},{"height":2400,"width":3000,"value":10}]},{"name":"operable","data":[{"height":500,"width":500,"value":11},{"height":914,"width":1514,"value":10},{"height":1200,"width":2400,"value":8}]}]'
        ];

        $pricingEquationParamsData = [
            '[{"name":"fixed","param_a":11,"param_b":39},{"name":"operable","param_a":9,"param_b":62}]'
        ];

        $flag = false;

        foreach ($fillingTypesData as $key => $item) {
            $filling = new FillingType();
            $filling->setName($item[0]);
            $filling->setSupplierName($item[1]);
            $filling->setType($item[2]);
            $filling->setWeightPerArea($item[3]);
            $filling->setPricingScheme($item[4]);
            $filling->setPosition($item[5]);

            $ftp = new FillingTypeProfile();
            $ftp->setFillingType($filling);
            $ftp->setProfile($om->getRepository('AppBundle:Profile')->findOneBy(array('id' => 1)));
            $ftp->setPricingGrids($pricingGridsData[0]);
            $ftp->setPricingEquationParams($pricingEquationParamsData[0]);

            $om->persist($ftp);

            if ($flag) {
                $ftp1 = new FillingTypeProfile();
                $ftp1->setFillingType($filling);
                $ftp1->setProfile($om->getRepository('AppBundle:Profile')->findOneBy(array('id' => 2)));
                $om->persist($ftp1);

                $ftp1->setPricingGrids($pricingGridsData[0]);
                $ftp1->setPricingEquationParams($pricingEquationParamsData[0]);

                $ftp2 = new FillingTypeProfile();
                $ftp2->setFillingType($filling);
                $ftp2->setProfile($om->getRepository('AppBundle:Profile')->findOneBy(array('id' => 3)));
                $om->persist($ftp2);

                $ftp2->setPricingGrids($pricingGridsData[0]);
                $ftp2->setPricingEquationParams($pricingEquationParamsData[0]);
            }

            $flag = true;

            $om->persist($filling);
            $om->flush();
        }
    }

    public function getOrder()
    {
        return 27;
    }
}