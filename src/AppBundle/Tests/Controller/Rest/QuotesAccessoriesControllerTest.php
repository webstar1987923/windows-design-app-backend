<?php

namespace AppBundle\Tests\Controller\Rest;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class QuotesAccessoriesControllerTest
 */
class QuotesAccessoriesControllerTest extends RestTestCase
{
    private static $apiRoute = '/api/projects/%d/quotes/%d/accessories';
    private static $parentProjectId = null;
    private static $parentQuoteId = null;
    private static $resourceId = null;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$parentProjectId = static::createTestProject();
        self::$parentQuoteId = QuotesControllerTest::createTestQuote(self::$parentProjectId);
        self::$apiRoute = sprintf(
            self::$apiRoute,
            self::$parentProjectId,
            self::$parentQuoteId
        );
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
        static::deleteTestProject(self::$parentProjectId);
        QuotesControllerTest::deleteTestQuote(self::$parentQuoteId);
    }

    public function testPostAccessoryAction()
    {
        $postResourceData = [
            'accessory' => [
                'description' => 'project_accessory_description_test1',
                'quantity' => '11.11',
                'extras_type' => 'project_accessory_extras_type_test1',
                'original_cost' => '12.12',
                'original_currency' => 'USD',
                'conversion_rate' => '13.13',
                'price_markup' => '14.14',
                'discount' => '15.15'
            ],
        ];

        $payload = json_encode($postResourceData);
        $this->client->request('POST', self::$apiRoute, [], [], ['CONTENT_TYPE' => 'application/json'], $payload);
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
        $this->assertArrayHasKey('accessory', $decoded);
        $this->assertArrayHasKey('id', $decoded['accessory']);

        self::$resourceId = $decoded['accessory']['id'];
    }

    public function testGetAccessoriesAction()
    {
        $this->client->request('GET', self::$apiRoute);
        $response = $this->client->getResponse();

        // check status code == 200
        $this->assertJsonResponse($response, Response::HTTP_OK);

        // check data
        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('accessories', $data);
        $this->assertArrayHasKey('offset', $data);
        $this->assertArrayHasKey('limit', $data);

        $this->assertArrayHasKey('id', $data['accessories'][0]);
    }

    public function testGetAccessoryAction()
    {
        $this->client->request('GET', sprintf('%s/%d', self::$apiRoute, self::$resourceId));
        $response = $this->client->getResponse();

        // check status code == 200
        $this->assertJsonResponse($response, Response::HTTP_OK);

        // check data
        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('accessory', $data);
        $this->assertArrayHasKey('id', $data['accessory']);

        $this->assertEquals(self::$resourceId, $data['accessory']['id']);
    }

    public function testPutAccessoryAction()
    {
        $putResourceData = [
            'accessory' => [
                'description' => 'project_accessory_description_test2',
                'quantity' => '11.112',
                'extras_type' => 'project_accessory_extras_type_test2',
                'original_cost' => '12.122',
                'original_currency' => 'EUR',
                'conversion_rate' => '13.132',
                'price_markup' => '14.142',
                'discount' => '15.152'
            ],
        ];

        $payload = json_encode($putResourceData);
        $this->client->request(
            'PUT',
            sprintf('%s/%d', self::$apiRoute, self::$resourceId),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $payload
        );
        $response = $this->client->getResponse();

        // check status code == 204
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());

        // check updated resource
        $this->client->request('GET', sprintf('%s/%d', self::$apiRoute, self::$resourceId));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, Response::HTTP_OK);
        $decoded = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('accessory', $decoded);
        $this->assertArrayHasKey('id', $decoded['accessory']);
        $this->assertEquals(self::$resourceId, $decoded['accessory']['id']);

        // check fields
        foreach ($putResourceData['accessory'] as $key => $value) {
            $this->assertEquals($value, $decoded['accessory'][$key]);
        }
    }

    public function testDeleteAccessoryAction()
    {
        $this->client->request('DELETE', sprintf('%s/%d', self::$apiRoute, self::$resourceId));
        $response = $this->client->getResponse();

        // check status code
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());

        $this->client->request('GET', sprintf('%s/%d', self::$apiRoute, self::$resourceId));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, Response::HTTP_NOT_FOUND);
    }

    public function testReorderAccessoriesAction()
    {
        // 1. Create several project accessories
        $rawElement = [
            'description' => 'Accessory made by func test',
            'quantity' => '11.11',
            'extras_type' => 'project_accessory_extras_type_test1',
            'original_cost' => '12.12',
            'original_currency' => 'USD',
            'conversion_rate' => '13.13',
            'price_markup' => '14.14',
            'discount' => '15.15'
        ];

        $items = array_fill(0, 5, $rawElement);

        foreach ($items as $item) {
            $payload = json_encode(['accessory' => $item]);
            $this->client->request('POST', self::$apiRoute, [], [], ['CONTENT_TYPE' => 'application/json'], $payload);
        }

        // 2. Get project accessories
        $this->client->request('GET', self::$apiRoute);
        $response = $this->client->getResponse();
        $content = $response->getContent();
        $items = json_decode($content, true)['accessories'];
        $this->assertEquals(5, count($items));

        // 3. Reorder accessories
        $accessoriesIds = array_column($items, "id");
        shuffle($accessoriesIds);
        $payload = json_encode(['accessories' => $accessoriesIds]);
        $url = str_replace('/accessories', '/reorder_accessories', self::$apiRoute);
        $this->client->request('POST', $url, [], [], ['CONTENT_TYPE' => 'application/json'], $payload);

        // 4. Check the order of units
        $this->client->request('GET', self::$apiRoute);
        $response = $this->client->getResponse();
        $content = $response->getContent();
        $items = json_decode($content, true)['accessories'];
        $itemsActualIDs = array_column($items, "id");
        $this->assertTrue($accessoriesIds === $itemsActualIDs);

        // remove test data
        $em = self::$kernel->getContainer()->get('doctrine.orm.default_entity_manager');
        $stmt = $em->getConnection()->prepare("DELETE FROM accessories WHERE id IN(" . implode(',', $accessoriesIds) . ")");
        $stmt->execute();
    }
}

