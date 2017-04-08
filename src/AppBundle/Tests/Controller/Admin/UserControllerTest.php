<?php

namespace AppBundle\Tests\Controller\Admin;

class UserControllerTest extends AdminWebTestCase
{
    private $client;
    private static $lastInsertedId = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testIndex()
    {
        $this->client->request('GET', self::ADMIN_ROUTE_PREFIX . '/users');
        $this->client->followRedirect();
        $crawler = $this->client->getCrawler();
        $this->assertEquals(1, $crawler->filter('h1:contains("Users list")')->count());
    }

    public function testCreate()
    {
        $this->client->request('GET', self::ADMIN_ROUTE_PREFIX . '/users/create');
        $crawler = $this->client->getCrawler();
        $this->assertEquals(1, $crawler->filter('body form[name="users"]')->count());
    }

    public function testCreateHandler()
    {
        $this->client->request('GET', self::ADMIN_ROUTE_PREFIX . '/users/create');
        $crawler = $this->client->getCrawler();
        $form = $crawler->filter('form[name=users]')->form();
        $form['users[username]'] = 'myUser';
        $form['users[password]'] = 'awesomePassword';
        $form['users[passwordConfirm]'] = 'awesomePassword';
        $form['users[email]'] = 'example@aa.aa';
        $form['users[firstname]'] = 'Firstname';
        $form['users[lastname]'] = 'Lastname';
        $form['users[roles]'] = 'ROLE_USER';
        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect());
        if ($this->client->getResponse()->isRedirect()) {
            $this->client->followRedirect();
            $crawler = $this->client->getCrawler();
            static::$lastInsertedId = $crawler->filter('tr:last-child td:first-child')->text();
        }

    }

    public function testUpdate()
    {
        static::$lastInsertedId ?
            $this->client->request('GET', self::ADMIN_ROUTE_PREFIX . '/users/' . static::$lastInsertedId . '/update') :
            $this->assertTrue(false, 'Could not get last inserted id');
        $crawler = $this->client->getCrawler();
        $this->assertEquals(1, $crawler->filter('body form[name="users"]')->count());
    }

    public function testUpdateHandler()
    {
        static::$lastInsertedId ?
            $this->client->request('GET', self::ADMIN_ROUTE_PREFIX . '/users/' . static::$lastInsertedId . '/update') :
            $this->assertTrue(false, 'Could not get last inserted id');
        $crawler = $this->client->getCrawler();
        $form = $crawler->filter('form[name=users]')->form();
        $form['users[username]'] = 'myUser';
        $form['users[email]'] = 'example@aa.aa';
        $form['users[firstname]'] = 'Firstname';
        $form['users[lastname]'] = 'Lastname';
        $form['users[roles]'] = 'ROLE_USER';
        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect());
    }

    public function testToggleLock()
    {
        static::$lastInsertedId ?
            $this->client->request('POST', self::ADMIN_ROUTE_PREFIX . '/users/' . static::$lastInsertedId . '/togglelock') :
            $this->assertTrue(false, 'Could not get last inserted id');
        $this->assertTrue($this->client->getResponse()->isRedirect());
    }

    public function testChangePassword()
    {
        static::$lastInsertedId ?
            $this->client->request('GET', self::ADMIN_ROUTE_PREFIX . '/users/' . static::$lastInsertedId . '/change_password') :
            $this->assertTrue(false, 'Could not get last inserted id');
        $crawler = $this->client->getCrawler();
        $this->assertEquals(1, $crawler->filter('body form[name="users"]')->count());
    }

    public function testChangePasswordHandler()
    {
        static::$lastInsertedId ?
            $this->client->request('GET', self::ADMIN_ROUTE_PREFIX . '/users/' . static::$lastInsertedId . '/change_password') :
            $this->assertTrue(false, 'Could not get last inserted id');
        $crawler = $this->client->getCrawler();
        $form = $crawler->filter('form[name=users]')->form();
        $form['users[password]'] = 'newAwesomePassword';
        $form['users[passwordConfirm]'] = 'newAwesomePassword';
        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect());
    }

    public function testDelete()
    {
        static::$lastInsertedId ?
            $this->client->request('POST', self::ADMIN_ROUTE_PREFIX . '/users/' . static::$lastInsertedId . '/delete') :
            $this->assertTrue(false, 'Could not get last inserted id');
        $this->assertTrue($this->client->getResponse()->isRedirect());

    }
}