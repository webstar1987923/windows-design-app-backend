<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Profile;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadProfileData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $om)
    {
        //$name, $unit_type, $frame_width, $mullion_width, $sash_frame_width, $sash_frame_overlap, $sash_mullion_overlap, $low_threshold, $threshold_width, $system
        $data = [
            ['Pinnacle uPVC', null, 70, 92, 82, 34, 12, null, null, 'Pinnacle uPVC Window', Profile::PRICING_SCHEME_PRICING_GRIDS],
            ['Pinnacle Entry Door', 'Patio Door', 84, 92, 120, 34, 12, true, 20, 'Pinnacle uPVC Entry Door', Profile::PRICING_SCHEME_PRICING_GRIDS],
            ['PE 78N HI Entry Door', 'Entry Door', 74, 94, 126, 28, 12, true, 20, 'Ponzio PE 78N HI', Profile::PRICING_SCHEME_PRICING_GRIDS],
        ];

        $pricingGridsData = [
            '{"fixed":[{"title":"Small","height":500,"width":500,"price_per_square_meter":50},{"title":"Medium","height":914,"width":1514,"price_per_square_meter":45},{"title":"Large","height":2400,"width":3000,"price_per_square_meter":40}],"operable":[{"title":"Small","height":500,"width":500,"price_per_square_meter":70},{"title":"Medium","height":914,"width":1514,"price_per_square_meter":65},{"title":"Large","height":1200,"width":2400,"price_per_square_meter":60}]}'
        ];
        $pricingEquationParamsData = [
            '[{"name":"fixed","param_a":341.72,"param_b":58.312},{"name":"operable","param_a":406.16,"param_b":192.16}]'
        ];

        foreach ($data as $key => $item) {
            $e = new Profile();
            $e->setName($item[0]);
            $e->setUnitType($item[1]);
            $e->setFrameWidth($item[2]);
            $e->setMullionWidth($item[3]);
            $e->setSashFrameWidth($item[4]);
            $e->setSashFrameOverlap($item[5]);
            $e->setSashMullionOverlap($item[6]);
            $e->setLowThreshold($item[7]);
            $e->setThresholdWidth($item[8]);
            $e->setSystem($item[9]);
            $e->setPricingScheme($item[10]);

            $e->setPricingGrids($pricingGridsData[0]);
            $e->setPricingEquationParams($pricingEquationParamsData[0]);

            $om->persist($e);

            $this->addReference('profile_'.$key, $e);
        }

        $om->flush();
    }

    public function getOrder()
    {
        return 25;
    }
}
