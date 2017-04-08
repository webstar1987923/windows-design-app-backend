<?php

namespace AppBundle\Tests\Controller\Rest;

use AppBundle\AppBundle;
use AppBundle\Entity\Dictionary;
use AppBundle\Entity\DictionaryEntry;
use AppBundle\Entity\Profile;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group dictentry
 */
class DictionaryEntryControllerTest extends RestTestCase
{
    private static $apiRoute = '/api/dictionaries/%d/entries';
    private static $resourceId = null;
    private static $items = [];

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    /**
     * @var QueryBuilder
     */
    protected $qb;

    /**
     * @var Dictionary
     */
    protected $dictionary;

    public function setUp()
    {
        parent::setUp();
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->qb = $this->em->getConnection()->createQueryBuilder();

        // Create Dictionary
        $this->dictionary = new Dictionary();
        $this->dictionary->setName("Matrix Actors");
        $this->dictionary->setRulesAndRestrictions("random_set_of_rules");
        $this->dictionary->setPosition(1);
        $this->em->persist($this->dictionary);
        $this->em->flush();
    }

    protected function getApiRoute() {
        return str_replace("%d", $this->dictionary->getId(), self::$apiRoute);
    }

    public function tearDown()
    {
        $this->em->refresh($this->dictionary);
        $this->em->remove($this->dictionary);
        $this->em->flush();
        $this->em->clear();
        parent::tearDown();

        $client = static::createAuthenticatedClient();
        foreach(self::$items as $resourceId) {
            $url = $this->getApiRoute() . '/{$resourceId}';
            $client->request('DELETE', $url);
        }
        $client=null;
    }

    public function testPostEntryAction()
    {
        $postData = [
            'entry' => [
                'name' => 'Gold Snack',
                'supplier_name' => 'Supplier Gold Snack',
                // @TODO data => [a => 1, b => 2]
                'data' => json_encode(['a' => 1, 'b' => 2]),
                'position' => 0
            ]
        ];
        $postDataJSON = json_encode($postData);

        $this->client->request('POST', $this->getApiRoute(), [], [], ['CONTENT_TYPE' => 'application/json'], $postDataJSON);
        $response = $this->client->getResponse();

        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_CREATED); // 201

        // Check location header exists
        $this->assertTrue($response->headers->has('Location'));

        // Check location header have path to new resource
        $location = $response->headers->get('Location');
        $this->assertStringMatchesFormat( '%s' .  self::$apiRoute . '/%d', $location);

        // Get created record ID
        $id = substr($location, strrpos($location, "/") + 1);

        // Test the record in database:
        /* @var $dictionary \AppBundle\Entity\Dictionary */
        $entry = $this->em->find("AppBundle:DictionaryEntry", $id);
        $this->assertNotEmpty($entry);

        $this->em->remove($entry);
    }

    public function testPutEntryAction()
    {
        // Create entry
        $entry = new DictionaryEntry();
        $entry->setName('Keanu Reeves');
        $entry->setSupplierName('Keanu Reeves Supplier');
        $entry->setDictionary($this->dictionary);
        $entry->setData('Not null data');
        $this->em->persist($entry);

        $profiles = [
            new Profile(),
            new Profile()
        ];
        $profiles[0]->setName('Profile 1');
        $profiles[1]->setName('Profile 2');

        foreach($profiles as $profile) {
            $this->em->persist($profile);
        }

        $this->em->flush();

        // Send update request with new data
        $putResourceData =
        [
            'entry' => [
                'name' => 'Carrie-Anne Moss',
                'supplier_name' => 'Carrie-Anne Moss Supplier',
                'data' => json_encode(['a' => 1, 'b' => 2]),
                'dictionary_entry_profiles' => [
                    [
                        'profile_id' => $profiles[0]->getId(),
                        'is_default' => true,
                        'pricing_grids' => 'pricing_grids_string_1',
                        'pricing_equation_params' => 'pricing_equation_params_string_1',
                        'cost_per_item' => 15.5,
                    ],
                    [
                        'profile_id' => $profiles[1]->getId(),
                        'pricing_grids' => 'pricing_grids_string_2',
                        'pricing_equation_params' => 'pricing_equation_params_string_2',
                        'cost_per_item' => 22,
                    ],
                ],
                'position' => 0
            ]
        ];

        $payload = json_encode($putResourceData);
        $url = $this->getApiRoute() . '/' . $entry->getId();
        $this->client->request('PUT', $url, [], [], ['CONTENT_TYPE' => 'application/json'], $payload);
        $response = $this->client->getResponse();

        // Check status code
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode()); // 204

        /* @var $entryCopy  */
        $this->em->detach($entry);

        // Get entry from database again
        /* @var $entryCopy \AppBundle\Entity\DictionaryEntry */
        $entryCopy = $this->em->find("AppBundle:DictionaryEntry", $entry->getId());
        $entryProfiles = $this->em->getRepository("AppBundle:DictionaryEntryProfile")->findBy(['entry' => $entryCopy]);
        // Assert that it equals to sent data
        $this->assertEquals($putResourceData['entry']['name'], $entryCopy->getName());
        $this->assertNotEmpty($entryProfiles);
        $this->assertCount(2, $entryProfiles);
        $this->assertTrue($entryProfiles[0]->getIsDefault());
        $this->assertEquals(
            $putResourceData['entry']['dictionary_entry_profiles'][0]['pricing_grids'],
            $entryProfiles[0]->getPricingGrids()
        );
        $this->assertEquals(
            $putResourceData['entry']['dictionary_entry_profiles'][0]['cost_per_item'],
            $entryProfiles[0]->getCostPerItem()
        );

        foreach ($entryProfiles as $p)
        {
            $this->em->remove($p);
        }
        $this->em->remove($entryCopy);
        foreach($profiles as $profile) {
            $this->em->remove($profile);
        }

        $this->em->flush();
    }

    public function testGetEntriesAction()
    {
        $entries = [
            [
                'name' => 'Keanu Reeves',
                'supplier_name' => 'Keanu Reeves Supplier',
                'data' => ['character' => 'Neo']
            ],
            [
                'name' => 'Carrie-Anne Moss',
                'supplier_name' => 'Carrie-Anne Moss Supplier',
                'data' => ['character' => 'Morpheus']
            ],
            [
                'name' => 'Hugo Weaving',
                'supplier_name' => 'Hugo Weaving Supplier',
                'data' => ['character' => 'Agent Smith']
            ]
        ];

        foreach ($entries as $key => $item) {
            $entry = new DictionaryEntry();
            $entry->setName($item['name']);
            $entry->setDictionary($this->dictionary);
            $entry->setData(json_encode($item['data']));
            $this->em->persist($entry);
            $entries[$key] = $entry;
        }
        $this->em->flush();

        $this->client->request('GET', $this->getApiRoute());
        $response = $this->client->getResponse();
        $this->assertJsonResponse($response, Response::HTTP_OK);

        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey("entries", $data);
        $this->assertCount(3, $data['entries']);

        $names = array_map(function ($item) {
            return $item['name'];
        }, $data['entries']);

        foreach ($entries as $entry) {
            $this->assertContains($entry->getName(), $names);
            $this->em->remove($entry);
        }
    }

    public function testGetEntryAction()
    {
        // create entry
        $entry = new DictionaryEntry();
        $entry->setName('Keanu Reeves');
        $entry->setDictionary($this->dictionary);
        $entry->setData('');
        $this->em->persist($entry);
        $this->em->flush();

        // look for it
        $url = $this->getApiRoute() . '/' . $entry->getId();
        $this->client->request("GET", $url);
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, Response::HTTP_OK);

        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey("dictionary_entry", $data);

        $this->assertEquals($entry->getId(), $data['dictionary_entry']['id']);

        $this->em->remove($entry);
    }

    public function testDeleteEntryAction()
    {
        // create entry
        $entry = new DictionaryEntry();
        $entry->setName('Keanu Reeves');
        $entry->setDictionary($this->dictionary);
        $entry->setData('');
        $this->em->persist($entry);
        $this->em->flush();

        // Delete entry via API
        $url = $this->getApiRoute() . '/' . $entry->getId();
        $this->client->request("DELETE", $url);
        $response = $this->client->getResponse();

        // Check status code
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode()); // 204

        // Check entry existence
        $this->em->detach($entry);
        $dictCopy = $this->em->find("AppBundle:DictionaryEntry", $entry->getId());
        $this->assertEmpty($dictCopy);
    }

    public function testReorderEntriesAction()
    {
        // 1. Create several dictionary entries
        $rawElement = [
            'name' => 'Entry made by func test',
            'data' => 'entry_test_data',
            'position' => 0
        ];

        $items = array_fill(0, 5, $rawElement);

        foreach ($items as $item) {
            $item['position']+=1;
            $payload = json_encode(['entry' => $item]);
            $this->client->request('POST', $this->getApiRoute(), [], [], ['CONTENT_TYPE' => 'application/json'], $payload);
        }

        // 2. Get dictionary entries
        $this->client->request('GET', $this->getApiRoute());
        $response = $this->client->getResponse();
        $content = $response->getContent();
        $items = json_decode($content, true)['entries'];
        $this->assertEquals(5, count($items));

        // 3. Reorder entries
        $itemsIDs = array_column($items, "id");
        shuffle($itemsIDs);
        $payload = json_encode(['entries' => $itemsIDs]);
        $url = str_replace('/entries', '/reorder_entries', self::$apiRoute);
        $url = str_replace("%d", $this->dictionary->getId(), $url);
        $this->client->request('POST', $url, [], [], ['CONTENT_TYPE' => 'application/json'], $payload);
//        var_dump($this->client->getResponse()->getContent());
        // 4. Check the order of entries
        $this->client->request('GET', $this->getApiRoute());
        $response = $this->client->getResponse();
        $content = $response->getContent();
        $items = json_decode($content, true)['entries'];
        $itemsActualIDs = array_column($items, "id");
        $this->assertEquals($itemsIDs, $itemsActualIDs);
    }
}
