<?php

namespace AppBundle\Tests\Controller\Rest;

use Symfony\Component\HttpFoundation\Response;

class ProjectsFilesControllerTest extends RestTestCase
{
    private static $apiRoute = '/api/projects/%s/files';
    private static $parentResourceId = null;
    private static $resourceId = null;

    public static function setUpBeforeClass() {
        //parent::setUp();
        self::$parentResourceId = static::createTestProject();
        self::$apiRoute = sprintf(self::$apiRoute, self::$parentResourceId);
    }

    public static function tearDownAfterClass() {
        static::deleteTestProject(self::$parentResourceId);
        //parent::tearDown();
    }


    public function testGetProjectFilesAction()
    {
        $this->client->request('GET', self::$apiRoute);
        $response = $this->client->getResponse();

        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_OK); // 200

        // Check data exists
        $content = $response->getContent();
        $decoded = json_decode($content, true);
        $this->assertTrue(isset($decoded['files']));
    }
}
