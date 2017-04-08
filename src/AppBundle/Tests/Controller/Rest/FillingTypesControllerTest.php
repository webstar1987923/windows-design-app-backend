<?php

namespace AppBundle\Tests\Controller\Rest;

use Symfony\Component\HttpFoundation\Response;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;

use AppBundle\Entity\FillingType;
use AppBundle\Entity\Profile;

class FillingTypesControllerTest extends RestTestCase
{
    private static $apiRoute = '/api/fillingtypes';
    private static $resourceId = null;
    private static $items = [];

    public static function tearDownAfterClass()
    {
        $client = static::createAuthenticatedClient();
        foreach(self::$items as $resourceId) {
            $client->request('DELETE', '/api/fillingtypes' . "/{$resourceId}");
        }
        $client=null;
    }

    public function testPostFillingTypesAction()
    {
        $postResourceData =
            ['filling_type' =>
                [
                    'name' => 'filling_type_name_test_1',
                    'supplier_name' => 'filling_type_supplier_name_test_1',
                    'type' => 'filling_type_type_test_1',
                    'pricing_scheme' => 'filling_type_pricing_scheme_test_1',
                ],
            ];

        $payload = json_encode($postResourceData);
        $this->client->request('POST', self::$apiRoute, [], [], ['CONTENT_TYPE' => 'application/json'], $payload);
        $response = $this->client->getResponse();

        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_CREATED); // 201

        // Check location header exists
        $this->assertTrue($response->headers->has('Location'));

        // Check location header have path to new resource
        $location = $response->headers->get('Location');
        $this->assertStringMatchesFormat('%s' . self::$apiRoute . '/%d', $location);

        // Get new project
        $this->client->request('GET', $location);
        $response = $this->client->getResponse();
        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_OK); // 200
        // Check data exists
        $content = $response->getContent();
        $decoded = json_decode($content, true);
        $this->assertTrue(isset($decoded['filling_type']['id']));

        self::$resourceId = $decoded['filling_type']['id'];
    }

    public function testGetFillingTypesAction()
    {
        $this->client->request('GET', self::$apiRoute);
        $response = $this->client->getResponse();

        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_OK); // 200

        // Check data exists
        $content = $response->getContent();
        $decoded = json_decode($content, true);
        $this->assertTrue(isset($decoded['filling_types']));
    }

    public function testGetFillingTypeAction()
    {
        $resourceId = self::$resourceId;

        $this->client->request('GET', self::$apiRoute . "/{$resourceId}");
        $response = $this->client->getResponse();

        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_OK); // 200

        // Check data exists
        $content = $response->getContent();
        $decoded = json_decode($content, true);
        $this->assertEquals($resourceId, $decoded['filling_type']['id']);
    }

    public function testPutFillingTypesAction() // Edit existing
    {
        /** @var EntityManager $em */
        $em = self::$kernel->getContainer()->get('doctrine.orm.default_entity_manager');

        $ft = new FillingType();
        $ft->setName('test_filling_type');
        $ft->setSupplierName('test_filling_type_supplier');
        $ft->setPosition(1);
        $ft->setType('test_type');
        $ft->setWeightPerArea('1.5');
        $ft->setPricingScheme('test_pricing_scheme');

        $em->persist($ft);

        $profiles = [
            new Profile(),
            new Profile()
        ];

        $profiles[0]->setName('test_profile_1');
        $profiles[1]->setName('test_profile_2');

        foreach($profiles as $profile) {
            $em->persist($profile);
        }

        $em->flush();

        $putResourceData = [
            'filling_type' => [
                'name' => 'test_filling_type',
                'supplier_name' => 'test_filling_type_supplier',
                'weight_per_area' => '1.5',
                'type' => 'test_type',
                'position' => 1,
                'pricing_scheme' => 'test_pricing_scheme',
                'filling_type_profiles' => [
                    [
                        'profile_id' => $profiles[0]->getId(),
                        'is_default' => true,
                        'pricing_grids' => 'pricing_grids_string_1',
                        'pricing_equation_params' => 'pricing_equation_params_string_1',
                    ],
                    [
                        'profile_id' => $profiles[1]->getId(),
                        'pricing_grids' => 'pricing_grids_string_2',
                        'pricing_equation_params' => 'pricing_equation_params_string_2',
                    ],
                ],
            ],
        ];

        $payload = json_encode($putResourceData);
        $url = self::$apiRoute . '/' . $ft->getId();
        $this->client->request('PUT', $url, [], [], ['CONTENT_TYPE' => 'application/json'], $payload);
        $response = $this->client->getResponse();

        // Check status code
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode()); // 204

        /* @var $ftCopy  */
        $em->detach($ft);

        // Get filling type from database again
        /* @var $ftCopy \AppBundle\Entity\FillingType */
        $ftCopy = $em->find("AppBundle:FillingType", $ft->getId());
        $ftProfiles = $em->getRepository("AppBundle:FillingTypeProfile")->findBy(['fillingType' => $ftCopy]);
        // Assert that it equals to sent data
        $this->assertEquals($putResourceData['filling_type']['name'], $ftCopy->getName());
        $this->assertEquals($putResourceData['filling_type']['supplier_name'], $ftCopy->getSupplierName());
        $this->assertEquals($putResourceData['filling_type']['pricing_scheme'], $ftCopy->getPricingScheme());
        $this->assertNotEmpty($ftProfiles);
        $this->assertCount(2, $ftProfiles);
        $this->assertTrue($ftProfiles[0]->getIsDefault());
        $this->assertEquals($putResourceData['filling_type']['filling_type_profiles'][0]['pricing_grids'], $ftProfiles[0]->getPricingGrids());
        $this->assertEquals($putResourceData['filling_type']['filling_type_profiles'][0]['pricing_equation_params'], $ftProfiles[0]->getPricingEquationParams());

        foreach ($ftProfiles as $p)
        {
            $em->remove($p);
        }

        $em->remove($ftCopy);

        foreach($profiles as $profile) {
            $em->remove($profile);
        }

        $em->flush();
    }

    public function testDeleteFillingTypesAction()
    {
        $resourceId = self::$resourceId;

        $this->client->request('DELETE', self::$apiRoute . "/{$resourceId}");
        $response = $this->client->getResponse();

        // Check status code
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode()); // 204

        // Get new project
        $this->client->request('GET', self::$apiRoute . "/{$resourceId}");
        $response = $this->client->getResponse();
        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_NOT_FOUND); // 404
    }

    public function testReorderAction()
    {
        // 1. Create several project accessories
        $rawElement = [
            'name' => 'filling_type_reorder',
            'supplier_name' => 'filling_type_supplier_name_test_1',
            'type' => 'filling_type_type_test_1'
        ];

        $items = array_fill(0, 5, $rawElement);

        foreach ($items as $item) {
            $payload = json_encode(['filling_type' => $item]);
            $this->client->request('POST', self::$apiRoute, [], [], ['CONTENT_TYPE' => 'application/json'], $payload);
            $location = $this->client->getResponse()->headers->get('Location');

            // Remember created items to delete them after test
            if(preg_match('#fillingtypes/(\d+)$#', $location, $m)) {
                self::$items[] = $m[1];
            }
        }

        // 2. Get project accessories
        $this->client->request('GET', self::$apiRoute);
        $response = $this->client->getResponse();
        $content = $response->getContent();
        $items = json_decode($content, true)['filling_types'];
        // Filter items
        $items = array_filter($items, function ($item) {return $item['name'] == 'filling_type_reorder';});
        $this->assertEquals(5, count($items));

        // 3. Reorder accessories
        $unitsIDs = array_column($items, "id");
        shuffle($unitsIDs);
        $payload = json_encode(['filling_types' => $unitsIDs]);
        $url = str_replace('/fillingtypes', '/reorder_fillingtypes', self::$apiRoute);
        $this->client->request('POST', $url, [], [], ['CONTENT_TYPE' => 'application/json'], $payload);

        // 4. Check the order of units
        $this->client->request('GET', self::$apiRoute);
        $response = $this->client->getResponse();
        $content = $response->getContent();
        $items = json_decode($content, true)['filling_types'];
        // Filter items
        $items = array_filter($items, function ($item) {return $item['name'] == 'filling_type_reorder';});
        $itemsActualIDs = array_column($items, "id");
        $this->assertEquals($unitsIDs, $itemsActualIDs);
    }

    public function testFillingTypeProfileCannotContainDuplicates()
    {
        /** @var EntityManager $em */
        $em = self::$kernel->getContainer()->get('doctrine.orm.default_entity_manager');

        $ft = new FillingType();
        $ft->setName('test_filling_type');
        $ft->setSupplierName('test_filling_type_supplier');
        $ft->setPosition(1);
        $ft->setType('test_type');
        $ft->setWeightPerArea('1.5');
        $ft->setPricingScheme('test_pricing_scheme');

        $em->persist($ft);

        $profile = new Profile();
        $profile->setName('test_profile');

        $em->persist($profile);
        $em->flush();

        $payload = [
            'filling_type' => [
                'name' => 'test_filling_type',
                'supplier_name' => 'test_filling_type_supplier',
                'weight_per_area' => '1.5',
                'type' => 'test_type',
                'position' => 1,
                'pricing_scheme' => 'test_pricing_scheme',
                'filling_type_profiles' => [
                    [
                        'profile_id' => $profile->getId(),
                    ],
                    [
                        'profile_id' => $profile->getId(),
                    ],
                ],
            ],
        ];

        $this->client->request(
            'PUT',
            sprintf(
                '%s/%d',
                self::$apiRoute,
                $ft->getId()
            ),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($payload)
        );

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());

        $decoded = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('errors', $decoded);
        $this->assertArrayHasKey('errors', $decoded['errors']);
        $this->assertTrue(in_array('Duplicate profiles', $decoded['errors']['errors']));

        // Delete test records
        $em->remove($ft);
        $em->remove($profile);
        $em->flush();
    }
}
