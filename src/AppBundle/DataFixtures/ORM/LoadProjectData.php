<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Project;

class LoadProjectData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $om)
    {
        // $client_name, $client_company_name, $client_phone, $client_email, $client_address, $project_name, $project_address
        $data = [
            ['John Doe', 'Doe Constructions', '012.345.6789', 'john@example.com', '99 4th Street Suite 001 Brooklyn, NY 12345', 'Fixture Project', '001 Fixture Project Site Philadelphia, PA'],
            ['John Doe', 'Doe Constructions', '012.345.6789', 'john@example.com', '99 4th Street Suite 001 Brooklyn, NY 12345', 'Pricing TT', 'Middle of Nowhere'],
            ['John Doe', 'Doe Constructions', '012.345.6789', 'john@example.com', '99 4th Street Suite 001 Brooklyn, NY 12345', 'Pricing Fixed', 'Middle of Nowhere']
        ];

        foreach ($data as $key => $item) {
            $p = new Project();
            $p->setClientName($item[0]);
            $p->setClientCompanyName($item[1]);
            $p->setClientPhone($item[2]);
            $p->setClientEmail($item[3]);
            $p->setClientAddress($item[4]);
            $p->setProjectName($item[5]);
            $p->setProjectAddress($item[6]);

            $om->persist($p);

            $this->addReference('project_'.$key, $p);
        }

        $om->flush();
    }

    public function getOrder()
    {
        return 20;
    }
}
