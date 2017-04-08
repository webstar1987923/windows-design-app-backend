<?php

namespace AppBundle\Tests\Controller\Rest;

use Symfony\Component\HttpFoundation\Response;

class UserssControllerTest extends RestTestCase
{
    private static $apiRoute = '/api/users';
    private static $resourceId;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        static::bootKernel();

        $em = self::$kernel->getContainer()->get('doctrine.orm.default_entity_manager');
        if (!$user = $em->getRepository('AppBundle:User')->findOneBy(['username' => 'admin'])) {
            throw new \PHPUnit_Framework_Exception('Admin user not found');
        }

        self::$resourceId = $user->getId();
    }

    public function testGetUsersCurrentAction()
    {
        $resourceId = self::$resourceId;

        $this->client->request('GET', self::$apiRoute . "/current");
        $response = $this->client->getResponse();

        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_OK); // 200

        // Check data exists
        $content = $response->getContent();
        $decoded = json_decode($content, true);
        $this->assertEquals($resourceId, $decoded['user']['id']);
    }

}
