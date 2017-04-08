<?php
namespace AppBundle\Tests\Controller\Admin;

use AppBundle\DataFixtures\ORM\LoadUserData;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminWebTestCase extends WebTestCase
{
    CONST ADMIN_ROUTE_PREFIX = '/admin';

    protected static function createClient(array $options = [], array $server = [])
    {
        static::bootKernel($options);

        $testDomain = static::$kernel->getContainer()->getParameter('test_domain');
        $server = array_merge([
            'PHP_AUTH_USER' => LoadUserData::ADMIN_LOGIN,
            'PHP_AUTH_PW'   => LoadUserData::ADMIN_PASS,
            'HTTP_HOST' => $testDomain
        ], $server);

        $client = static::$kernel->getContainer()->get('test.client');
        $client->setServerParameters($server);

        //self::login($client);
        return $client;
    }

//    protected static function login($client) {
//        $crawler = $client->request('GET', '/login');
//
//        $form = $crawler->selectButton('_submit')->form();
//
//        $crawler = $client->submit(
//            $form, [
//                '_username' => LoadUserData::ADMIN_EMAIL,
//                '_password' => LoadUserData::ADMIN_PASS
//            ]
//        );
//
//        $crawler = $client->followRedirect();
//    }
}
