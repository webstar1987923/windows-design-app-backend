<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\User;


class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    CONST ADMIN_LOGIN = 'admin';
    CONST ADMIN_EMAIL = 'admin@prossimo.us';
    CONST ADMIN_PASS = '12345678';
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    public function load(ObjectManager $om)
    {
        $encoder = $this->container->get('security.password_encoder');

        $userAdmin = new User();
        $userAdmin->setUsername(self::ADMIN_LOGIN);
        $userAdmin->setUsernameCanonical(strtolower($userAdmin->getUsername()));
        $userAdmin->setEmail(self::ADMIN_EMAIL);
        $userAdmin->setPassword($encoder->encodePassword($userAdmin, self::ADMIN_PASS));
        $userAdmin->setFirstname('AdminFirstname');
        $userAdmin->setLastname('AdminLastname');
        $userAdmin->setLocked(false);
        $userAdmin->setEnabled(true);
        $userAdmin->setRoles(array(self::ROLE_SUPER_ADMIN));

        $om->persist($userAdmin);
        $om->flush();

        $this->addReference('user-admin', $userAdmin);
    }

    public function getOrder()
    {
        return 10;
    }

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

}
