<?php

namespace AppBundle\Tests\Controller\Rest;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class QuotesControllerTest
 */
class QuotesControllerTest extends RestTestCase
{
    private static $apiRoute = '/api/projects/%d/quotes';
    private static $parentResourceId = null;
    private static $resourceId = null;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$parentResourceId = static::createTestProject();
        self::$apiRoute = sprintf(self::$apiRoute, self::$parentResourceId);
    }

    public static function tearDownAfterClass() {
        parent::tearDownAfterClass();
        static::deleteTestProject(self::$parentResourceId);
    }

    public static function createTestQuote($projectId)
    {
        $url = sprintf('/api/projects/%d/quotes', $projectId);
        $client = static::createAuthenticatedClient();

        $client->request('POST', $url, [], [], ['CONTENT_TYPE' => 'application/json'], null);
        $response = $client->getResponse();

        $location = $response->headers->get('Location');
        $client->request('GET', $location);
        $response = $client->getResponse();

        return json_decode($response->getContent(), true)['quote']['id'];
    }

    public static function deleteTestQuote($quoteId)
    {
        $client = static::createAuthenticatedClient();
        $client->request('DELETE', sprintf('%s/%d', self::$apiRoute, $quoteId));
    }

    public function testPostQuoteAction()
    {
        $this->client->request('POST', self::$apiRoute, [], [], ['CONTENT_TYPE' => 'application/json'], null);

        $response = $this->client->getResponse();

        // check status code == 201
        $this->assertJsonResponse($response, Response::HTTP_CREATED);

        // check that we have a location header
        $this->assertTrue($response->headers->has('Location'));

        // check location path
        $this->assertStringMatchesFormat(
            '%s' . self::$apiRoute . '/%d',
            $response->headers->get('Location')
        );

        // check newly created resource
        $this->client->request('GET', $response->headers->get('Location'));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, Response::HTTP_OK);
        $decoded = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('quote', $decoded);
        $this->assertArrayHasKey('id', $decoded['quote']);
        $this->assertArrayHasKey('is_default', $decoded['quote']);

        // The quote we've just created is not default, because test project
        // already got an automatically created default quote
        $this->assertFalse($decoded['quote']['is_default']);

        self::$resourceId = $decoded['quote']['id'];
    }

    public function testPutQuoteAction()
    {
        $putResourceData = [
            'quote' => [
                'name'     => 'Test Quote',
                'revision' => 1,
                'date'     => time(),
                'position' => 1,
            ]
        ];

        $payload = json_encode($putResourceData);

        $this->client->request('PUT', sprintf('%s/%d', self::$apiRoute, self::$resourceId), [], [], ['CONTENT_TYPE' => 'application/json'], $payload);
        $response = $this->client->getResponse();

        // check status code == 204
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());

        $this->client->request('GET', sprintf('%s/%d', self::$apiRoute, self::$resourceId));
        $response = $this->client->getResponse();

        $content = $response->getContent();
        $decoded = json_decode($content, true);

        // Check every field updated value
        foreach ($putResourceData['quote'] as $key => $value) {
            $this->assertEquals($value, $decoded['quote'][$key]);
        }
    }

    public function testGetQuotesAction()
    {
        $this->client->request('GET', self::$apiRoute);
        $response = $this->client->getResponse();

        // check status code == 200
        $this->assertJsonResponse($response, Response::HTTP_OK);

        // check data
        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('quotes', $data);
        $this->assertArrayHasKey('offset', $data);
        $this->assertArrayHasKey('limit', $data);

        $this->assertArrayHasKey('id', $data['quotes'][0]);
    }

    public function testGetQuoteAction()
    {
        $this->client->request('GET', sprintf('%s/%d', self::$apiRoute, self::$resourceId));
        $response = $this->client->getResponse();

        // check status code == 200
        $this->assertJsonResponse($response, Response::HTTP_OK);

        // check data
        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('quote', $data);
        $this->assertArrayHasKey('id', $data['quote']);

        $this->assertEquals(self::$resourceId, $data['quote']['id']);
    }

    public function testDeleteQuoteAction()
    {
        $this->client->request('DELETE', sprintf('%s/%d', self::$apiRoute, self::$resourceId));
        $response = $this->client->getResponse();

        // check status code
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());

        $this->client->request('GET', sprintf('%s/%d', self::$apiRoute, self::$resourceId));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, Response::HTTP_NOT_FOUND);
    }

    public function testReorderQuotesAction()
    {
        for ($i = 0; $i < 5; $i++) {
            $this->client->request('POST', self::$apiRoute, [], [], ['CONTENT_TYPE' => 'application/json'], null);
        }

        $this->client->request('GET', self::$apiRoute);
        $response = $this->client->getResponse();
        $content = $response->getContent();
        $items = json_decode($content, true)['quotes'];
        $this->assertEquals(6, count($items));

        $quoteIds = array_column($items, 'id');
        shuffle($quoteIds);
        $payload = json_encode(['quotes' => $quoteIds]);
        $url = str_replace('/quotes', '/reorder_quotes', self::$apiRoute);
        $this->client->request('POST', $url, [], [], ['CONTENT_TYPE' => 'application/json'], $payload);

        $this->client->request('GET', self::$apiRoute);
        $response = $this->client->getResponse();
        $content = $response->getContent();
        $items = json_decode($content, true)['quotes'];
        $itemsActualIDs = array_column($items, "id");
        $this->assertTrue($quoteIds === $itemsActualIDs);

        // remove test data
        $em = self::$kernel->getContainer()->get('doctrine.orm.default_entity_manager');
        $stmt = $em->getConnection()->prepare("DELETE FROM quotes WHERE id IN(" . implode(',', $quoteIds) . ")");
        $stmt->execute();
    }
}
