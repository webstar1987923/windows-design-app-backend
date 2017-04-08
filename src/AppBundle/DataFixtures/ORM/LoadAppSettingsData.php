<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\AppSetting;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAppSettingsData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $om)
    {
        //$system_name, $display_name, $value
        $data = [
            array('thumbnails_save_ratio', 'Save ratio', 'thumbnails', '1'),
            array('thumbnails_width', 'Width, px', 'thumbnails', '200'),
            array('thumbnails_height', 'Height, px', 'thumbnails', '150'),
            array('thumbnails_quality', 'Quality (for jpeg only), %', 'thumbnails', '75'),
        ];

        foreach ($data as $key => $item) {
            $e = new AppSetting();
            $e->setSystemName($item[0]);
            $e->setDisplayName($item[1]);
            $e->setGroupName($item[2]);
            $e->setValue($item[3]);

            $om->persist($e);

            $this->addReference('app_setting_' . $key, $e);
        }

        $om->flush();
    }

    public function getOrder()
    {
        return 0;
    }
}
