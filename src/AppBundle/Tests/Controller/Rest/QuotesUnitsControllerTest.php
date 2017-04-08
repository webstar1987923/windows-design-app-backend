<?php

namespace AppBundle\Tests\Controller\Rest;

use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Dictionary;
use AppBundle\Entity\DictionaryEntry;

/**
 * Class QuotesUnitsControllerTest
 */
class QuotesUnitsControllerTest extends RestTestCase
{
    private static $apiRoute = '/api/projects/%d/quotes/%d/units';
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

    public function testPostUnitsAction()
    {
        $postResourceData = [
            'unit' => [
                'mark' => 'project_unit_mark_test1',
                'width' => '11.11',
                'height' => '12.12',
                'quantity' => '1',
                'description' => 'project_unit_description_test1',
                'notes' => 'project_unit_notes_test1',
                'exceptions' => 'project_unit_exceptions_test1',
                'profile_name' => 'project_unit_profile_name_test1',
                'profile_id' => 2,
                'customer_image' => 'project_unit_customer_image_test1',
                'internal_color' => 'project_unit_internal_color_test1',
                'external_color' => 'project_unit_external_color_test1',
                'interior_handle' => 'project_unit_interior_handle_test1',
                'exterior_handle' => 'project_unit_exterior_handle_test1',
                'hardware_type' => 'project_unit_hardware_type_test1',
                'lock_mechanism' => 'project_unit_lock_mechanism_test1',
                'glazing_bead' => 'project_unit_glazing_bead_test1',
                'gasket_color' => 'project_unit_gasket_color_test1',
                'hinge_style' => 'project_unit_hinge_style_test1',
                'opening_direction' => 'project_unit_opening_direction_test1',
                'internal_sill' => 'project_unit_internal_sill_test1',
                'external_sill' => 'project_unit_external_sill_test1',
                'glazing' => 'project_unit_glazing_test1',
                'uw' => '13.13',
                'original_cost' => '14.14',
                'original_currency' => 'USD',
                'conversion_rate' => '15.15',
                'supplier_discount' => '16.16',
                'price_markup' => '17.17',
                'discount' => '18.18',
                'root_section' => 'project_unit_root_section_test1',
                'glazing_bar_width' => '19.19',
                'glazing_bar_type' => 'project_unit_glazing_bar_type_test1',
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
        $this->assertArrayHasKey('unit', $decoded);
        $this->assertArrayHasKey('id', $decoded['unit']);

        self::$resourceId = $decoded['unit']['id'];
    }

    public function testGetUnitsAction()
    {
        $this->client->request('GET', self::$apiRoute);
        $response = $this->client->getResponse();

        // check status code == 200
        $this->assertJsonResponse($response, Response::HTTP_OK);

        // check data
        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('units', $data);
        $this->assertArrayHasKey('offset', $data);
        $this->assertArrayHasKey('limit', $data);

        $this->assertArrayHasKey('id', $data['units'][0]);
    }

    public function testGetUnitAction()
    {
        $this->client->request('GET', sprintf('%s/%d', self::$apiRoute, self::$resourceId));
        $response = $this->client->getResponse();

        // check status code == 200
        $this->assertJsonResponse($response, Response::HTTP_OK);

        // check data
        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('unit', $data);
        $this->assertArrayHasKey('id', $data['unit']);

        $this->assertEquals(self::$resourceId, $data['unit']['id']);
    }

    public function testPutUnitsAction()
    {
        $putResourceData = [
            'unit' => [
                'mark' => 'project_unit_mark_test2',
                'width' => '11.112',
                'height' => '12.122',
                'quantity' => '12',
                'description' => 'project_unit_description_test2',
                'notes' => 'project_unit_notes_test2',
                'exceptions' => 'project_unit_exceptions_test2',
                'profile_name' => 'project_unit_profile_name_test2',
                'customer_image' => 'project_unit_customer_image_test2',
                'internal_color' => 'project_unit_internal_color_test2',
                'external_color' => 'project_unit_external_color_test2',
                'interior_handle' => 'project_unit_interior_handle_test2',
                'exterior_handle' => 'project_unit_exterior_handle_test2',
                'hardware_type' => 'project_unit_hardware_type_test2',
                'lock_mechanism' => 'project_unit_lock_mechanism_test2',
                'glazing_bead' => 'project_unit_glazing_bead_test2',
                'gasket_color' => 'project_unit_gasket_color_test2',
                'hinge_style' => 'project_unit_hinge_style_test2',
                'opening_direction' => 'project_unit_opening_direction_test2',
                'internal_sill' => 'project_unit_internal_sill_test2',
                'external_sill' => 'project_unit_external_sill_test2',
                'glazing' => 'project_unit_glazing_test2',
                'uw' => '13.132',
                'original_cost' => '14.142',
                'original_currency' => 'EUR',
                'conversion_rate' => '15.152',
                'supplier_discount' => '16.162',
                'price_markup' => '17.172',
                'discount' => '18.182',
                'root_section' => 'project_unit_root_section_test2',
                'glazing_bar_width' => '19.192',
                'glazing_bar_type' => 'project_unit_glazing_bar_type_test2'
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
        $this->assertArrayHasKey('unit', $decoded);
        $this->assertArrayHasKey('id', $decoded['unit']);
        $this->assertEquals(self::$resourceId, $decoded['unit']['id']);

        // check fields
        foreach ($putResourceData['unit'] as $key => $value) {
            $this->assertEquals($value, $decoded['unit'][$key]);
        }
    }

    public function testPostUnitOptionsAction()
    {
        $em = self::$kernel->getContainer()->get('doctrine.orm.default_entity_manager');

        // create some dictionaries
        $testDictionary = new Dictionary();
        $testDictionary->setName('test_dictionary');

        $em->persist($testDictionary);

        $testDictEntries = [
            (new DictionaryEntry())
                ->setName('test_entry_001')
                ->setDictionary($testDictionary)
                ->setPosition(1)
                ->setData(''),
            (new DictionaryEntry())
                ->setName('test_entry_002')
                ->setDictionary($testDictionary)
                ->setPosition(2)
                ->setData(''),
        ];

        foreach ($testDictEntries as $testDictEntry) {
            $em->persist($testDictEntry);
        }

        $em->flush();

        $unitOptionsData = [
            'unit_options' => [
                ['dictionary_entry_id' => $testDictEntries[0]->getId()],
                ['dictionary_entry_id' => $testDictEntries[1]->getId()],
            ]
        ];

        $payload = json_encode($unitOptionsData);
        $this->client->request(
            'POST',
            sprintf('%s/%d/options', self::$apiRoute, self::$resourceId),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $payload
        );
        $response = $this->client->getResponse();

        $this->assertEquals($response->getStatusCode(), Response::HTTP_NO_CONTENT);

        $savedUnitOptions = $em
            ->getRepository('AppBundle:UnitOption')
            ->findBy(['dictionary' => $testDictionary])
        ;

        $this->assertNotEmpty($savedUnitOptions);

        $testDictionaryEntryIds = array_map(function($dEntry){
            return $dEntry->getId();
        }, $testDictEntries);

        foreach ($savedUnitOptions as $savedUnitOption) {
            $this->assertTrue(
                in_array(
                    $savedUnitOption->getDictionaryEntry()->getId(),
                    $testDictionaryEntryIds
                )
            );
        }

        // remove test data
        foreach ($savedUnitOptions as $savedUnitOption) {
            $em->remove($savedUnitOption);
        }

        foreach ($testDictEntries as $testDictEntry) {
            $em->remove($testDictEntry);
        }

        $em->remove($testDictionary);
        $em->flush();
    }

    public function testDeleteUnitsAction()
    {
        $this->client->request('DELETE', sprintf('%s/%d', self::$apiRoute, self::$resourceId));
        $response = $this->client->getResponse();

        // check status code
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());

        $this->client->request('GET', sprintf('%s/%d', self::$apiRoute, self::$resourceId));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, Response::HTTP_NOT_FOUND);
    }

    public function testReorderAction()
    {
        // 1. Create several project units
        $unitData = [
            'mark' => 'project_unit_mark_test2',
            'width' => '11.112',
            'height' => '12.122',
            'quantity' => '12',
            'description' => 'project_unit_description_test2',
            'notes' => 'project_unit_notes_test2',
            'exceptions' => 'project_unit_exceptions_test2',
            'profile_name' => 'project_unit_profile_name_test2',
            'profile_id' => 1,
            'customer_image' => 'project_unit_customer_image_test2',
            'internal_color' => 'project_unit_internal_color_test2',
            'external_color' => 'project_unit_external_color_test2',
            'interior_handle' => 'project_unit_interior_handle_test2',
            'exterior_handle' => 'project_unit_exterior_handle_test2',
            'hardware_type' => 'project_unit_hardware_type_test2',
            'lock_mechanism' => 'project_unit_lock_mechanism_test2',
            'glazing_bead' => 'project_unit_glazing_bead_test2',
            'gasket_color' => 'project_unit_gasket_color_test2',
            'hinge_style' => 'project_unit_hinge_style_test2',
            'opening_direction' => 'project_unit_opening_direction_test2',
            'internal_sill' => 'project_unit_internal_sill_test2',
            'external_sill' => 'project_unit_external_sill_test2',
            'glazing' => 'project_unit_glazing_test2',
            'uw' => '13.132',
            'original_cost' => '14.142',
            'original_currency' => 'EUR',
            'conversion_rate' => '15.152',
            'supplier_discount' => '16.162',
            'price_markup' => '17.172',
            'discount' => '18.182',
            'root_section' => 'project_unit_root_section_test2',
            'glazing_bar_width' => '19.192',
            'glazing_bar_type' => 'project_unit_glazing_bar_type_test2'
        ];

        $units = array_fill(0, 5, $unitData);

        foreach ($units as $unit) {
            $payload = json_encode(['unit' => $unit]);
            $this->client->request('POST', self::$apiRoute, [], [], ['CONTENT_TYPE' => 'application/json'], $payload);
        }

        // 2. Get project units
        $this->client->request('GET', self::$apiRoute);
        $response = $this->client->getResponse();
        $content = $response->getContent();
        $units = json_decode($content, true)['units'];
        $this->assertEquals(5, count($units));

        // 3. Reorder units
        $unitsIDs = array_column($units, "id");
        shuffle($unitsIDs);
        $payload = json_encode(['units' => $unitsIDs]);
        $url = str_replace('/units', '/reorder_units', self::$apiRoute);
        $this->client->request('POST', $url, [], [], ['CONTENT_TYPE' => 'application/json'], $payload);

        // 4. Check the order of units
        $this->client->request('GET', self::$apiRoute);
        $response = $this->client->getResponse();
        $content = $response->getContent();
        $units = json_decode($content, true)['units'];
        $unitsActualIDs = array_column($units, "id");
        $this->assertTrue($unitsIDs === $unitsActualIDs);

        // remove test data
        $em = self::$kernel->getContainer()->get('doctrine.orm.default_entity_manager');
        $stmt = $em->getConnection()->prepare("DELETE FROM units WHERE id IN(" . implode(',', $unitsIDs) . ")");
        $stmt->execute();
    }
}
