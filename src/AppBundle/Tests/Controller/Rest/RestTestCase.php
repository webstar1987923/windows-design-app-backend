<?php

namespace AppBundle\Tests\Controller\Rest;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RestTestCase extends WebTestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    protected $client = null;

    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     * @param string $password
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected static function createAuthenticatedClient($username = 'admin', $password = '12345678')
    {
        $client = static::createClient([],[
            'HTTP_HOST' => 'prossimo.local',
            //'HTTP_USER_AGENT' => 'MySuperBrowser/1.0',
        ]);
        $client->request(
            'POST',
            '/api/login_check',
            array(
                '_username' => $username,
                '_password' => $password,
            )
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client = static::createClient([],[
            'HTTP_HOST' => 'prossimo.local',
            //'HTTP_USER_AGENT' => 'MySuperBrowser/1.0',
        ]);
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));
        $client->setServerParameter('HTTP_ACCEPT', 'application/json');
        return $client;
    }

    public function setUp(){
        $this->client = $this->createAuthenticatedClient();
    }

    public function tearDown()
    {
        // Shutdown the kernel.
        static::$kernel->shutdown();

        parent::tearDown();
    }
//
//
//    protected function post($uri, $data)
//    {
//        $content = json_encode($data);
//        $parameters = [];
//        $files = [];
//        $server = ['CONTENT_TYPE' => 'application/json'];
//        $client = static::createClient();
//        $client->request('POST', $uri, $parameters, $files, $server, $content);
//
//        return $client->getResponse();
//    }

    /**
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param int $statusCode
     */
    protected function assertJsonResponse($response, $statusCode = Response::HTTP_OK) {
        $this->assertEquals(
            $statusCode, $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }

    protected static function createTestProject() {
        $client = static::createAuthenticatedClient();
        $postResourceData =
            ['project' =>
                [
                    'client_name' => '',
                    'client_company_name' => '',
                    'client_phone' => '',
                    'client_email' => '',
                    'client_address' => '',
                    'project_name' => '',
                    'project_address' => '',
                    'quote_date' => '',
                    'quote_revision' => '1'
                ],
            ];

        $payload = json_encode($postResourceData);
        $client->request('POST', '/api/projects', [], [], ['CONTENT_TYPE' => 'application/json'], $payload);
        $response = $client->getResponse();

        $location = $response->headers->get('Location');
        $client->request('GET', $location);
        $response = $client->getResponse();

        $content = $response->getContent();
        $decoded = json_decode($content, true);

        $client=null;
        return $decoded['project']['id'];
    }

    protected static function deleteTestProject($resourceId) {
        $client = static::createAuthenticatedClient();
        $client->request('DELETE', '/api/projects' . "/{$resourceId}");
        $client=null;
    }
}
