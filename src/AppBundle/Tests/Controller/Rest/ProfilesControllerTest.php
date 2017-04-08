<?php

namespace AppBundle\Tests\Controller\Rest;

use AppBundle\Entity\Dictionary;
use AppBundle\Entity\DictionaryEntry;
use AppBundle\Entity\Profile;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group profiles
 */
class ProfilesControllerTest extends RestTestCase
{
    private static $apiRoute = '/api/profiles';
    private static $resourceId = null;
    private static $items = [];

    public static function tearDownAfterClass()
    {
        $client = static::createAuthenticatedClient();
        foreach(self::$items as $resourceId) {
            $client->request('DELETE', '/api/profiles' . "/{$resourceId}");
        }
        $client=null;
    }

    public function testPostProfileAction()
    {
        $postResourceData =
            ['profile' =>
                [
                    'name' => 'profile_test_1',
                    'unit_type' => 'profile_unit_type_test_1',
                    'system' => 'profile_system_test_1',
                    'supplier_system' => 'profile_supplier_system_test_1',
                    'frame_width' => '10.01',
                    'mullion_width' => '11.11',
                    'sash_frame_width' => '12.12',
                    'sash_frame_overlap' => '13.13',
                    'sash_mullion_overlap' => '14.14',
                    'frame_corners' => 'profile_frame_corners_test_1',
                    'sash_corners' => 'profile_sash_corners_test_1',
                    'threshold_width' => '15.15',
                    'low_threshold' => true, // TRUE
                    'frame_u_value' => '16.16',
                    'spacer_thermal_bridge_value' => '17.17',
                    'pricing_scheme' => 'profile_pricing_scheme_test_1',
                    'pricing_grids' => 'profile_pricing_grids_test_1',
                    'pricing_equation_params' => 'profile_pricing_equation_params_test_1',
                    'clear_width_deduction' => '18.18',
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
        $this->assertTrue(isset($decoded['profile']['id']));

        self::$resourceId = $decoded['profile']['id'];
    }

    public function testGetProfilesAction()
    {
        $this->client->request('GET', self::$apiRoute);
        $response = $this->client->getResponse();

        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_OK); // 200

        // Check data exists
        $content = $response->getContent();
        $decoded = json_decode($content, true);
        $this->assertTrue(isset($decoded['profiles']));

        // Have at least one profile
        $this->assertNotEmpty($decoded['profiles'][0]);
        // And this profile doesn't contain units
        $this->assertArrayNotHasKey('units', $decoded['profiles'][0]);
    }

    public function testGetProfileAction()
    {
        $resourceId = self::$resourceId;

        $this->client->request('GET', self::$apiRoute . "/{$resourceId}");
        $response = $this->client->getResponse();

        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_OK); // 200

        // Check data exists
        $content = $response->getContent();
        $decoded = json_decode($content, true);
        $this->assertEquals($resourceId, $decoded['profile']['id']);
    }

    public function testPutProfileAction() // Edit existing
    {
        $resourceId = self::$resourceId;
        // Get previously created resource
        $putResourceData =
            ['profile' =>
                [
                    'name' => 'profile_test_2',
                    'unit_type' => 'profile_unit_type_test_2',
                    'system' => 'profile_system_test_2',
                    'supplier_system' => 'profile_supplier_system_test_2',
                    'frame_width' => '10.012',
                    'mullion_width' => '11.112',
                    'sash_frame_width' => '12.122',
                    'sash_frame_overlap' => '13.132',
                    'sash_mullion_overlap' => '14.142',
                    'frame_corners' => 'profile_frame_corners_test_2',
                    'sash_corners' => 'profile_sash_corners_test_2',
                    'threshold_width' => '15.152',
                    'low_threshold' => false, // FALSE
                    'frame_u_value' => '16.162',
                    'spacer_thermal_bridge_value' => '17.172',
                    'pricing_scheme' => 'profile_pricing_scheme_test_2',
                    'pricing_grids' => 'profile_pricing_grids_test_2',
                    'pricing_equation_params' => 'profile_pricing_equation_params_test_2',
                    'clear_width_deduction' => '18.182',
                ],
            ];

        $payload = json_encode($putResourceData);
        $this->client->request('PUT', self::$apiRoute . "/{$resourceId}", [], [], ['CONTENT_TYPE' => 'application/json'], $payload);
        $response = $this->client->getResponse();

        // Check status code
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode()); // 204

        // Get new project
        $this->client->request('GET', self::$apiRoute . "/{$resourceId}");
        $response = $this->client->getResponse();
        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_OK); // 200
        // Check data exists
        $content = $response->getContent();
        $decoded = json_decode($content, true);
        $this->assertEquals($resourceId, $decoded['profile']['id']);

        // Check every field updated value
        foreach ($putResourceData['profile'] as $key => $value) {
            $this->assertEquals($value, $decoded['profile'][$key]);
        }
    }

    public function testDeleteProfileAction()
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
        // 1. Create several profiles
        $rawElement = [
            'name' => 'profile_test_reorder',
            'unit_type' => 'profile_unit_type_test_1',
            'system' => 'profile_system_test_1',
            'supplier_system' => 'profile_supplier_system_test_1',
            'frame_width' => '10.01',
            'mullion_width' => '11.11',
            'sash_frame_width' => '12.12',
            'sash_frame_overlap' => '13.13',
            'sash_mullion_overlap' => '14.14',
            'frame_corners' => 'profile_frame_corners_test_1',
            'sash_corners' => 'profile_sash_corners_test_1',
            'threshold_width' => '15.15',
            'low_threshold' => true, // TRUE
            'frame_u_value' => '16.16',
            'spacer_thermal_bridge_value' => '17.17',
            'pricing_scheme' => 'profile_pricing_scheme_test_1',
            'pricing_grids' => 'profile_pricing_grids_test_1',
            'pricing_equation_params' => 'profile_pricing_equation_params_test_1',
            'clear_width_deduction' => '18.18',
        ];

        $items = array_fill(0, 5, $rawElement);

        foreach ($items as $item) {
            $payload = json_encode(['profile' => $item]);
            $this->client->request('POST', self::$apiRoute, [], [], ['CONTENT_TYPE' => 'application/json'], $payload);
            $location = $this->client->getResponse()->headers->get('Location');

            // Remember created items to delete them after test
            if(preg_match('#profiles/(\d+)$#', $location, $m)) {
                self::$items[] = $m[1];
            }
        }

        // 2. Get profiles
        $this->client->request('GET', self::$apiRoute);
        $response = $this->client->getResponse();
        $content = $response->getContent();
        $items = json_decode($content, true)['profiles'];
        // Filter items
        $items = array_filter($items, function ($item) {return $item['name'] == 'profile_test_reorder';});
        $this->assertEquals(5, count($items));

        // 3. Reorder profiles
        $unitsIDs = array_column($items, "id");
        shuffle($unitsIDs);
        $payload = json_encode(['profiles' => $unitsIDs]);
        $url = str_replace('/profiles', '/reorder_profiles', self::$apiRoute);
        $this->client->request('POST', $url, [], [], ['CONTENT_TYPE' => 'application/json'], $payload);

        // 4. Check the order of profiles
        $this->client->request('GET', self::$apiRoute);
        $response = $this->client->getResponse();
        $content = $response->getContent();
        $items = json_decode($content, true)['profiles'];
        // Filter items
        $items = array_filter($items, function ($item) {return $item['name'] == 'profile_test_reorder';});
        $itemsActualIDs = array_column($items, "id");
        $this->assertEquals($unitsIDs, $itemsActualIDs);
    }
}
