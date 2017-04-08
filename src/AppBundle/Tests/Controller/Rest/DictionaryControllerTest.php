<?php

namespace AppBundle\Tests\Controller\Rest;

use Symfony\Component\HttpFoundation\Response;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;

use AppBundle\Entity\Dictionary;
use AppBundle\Entity\DictionaryEntry;
use AppBundle\Entity\DictionaryEntryProfile;
use AppBundle\Entity\Profile;

class DictionaryControllerTest extends RestTestCase
{
    private static $apiRoute = '/api/dictionaries';
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

    public function setUp()
    {
        parent::setUp();
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->qb = $this->em->getConnection()->createQueryBuilder();
    }

    public static function tearDownAfterClass()
    {
        $client = static::createAuthenticatedClient();
        foreach(self::$items as $resourceId) {
            $client->request('DELETE', '/api/dictionaries' . "/{$resourceId}");
        }
        $client=null;
    }

    public function testPostDictionaries()
    {
        $postData = ['dictionary' => [
            'name' => 'Window test type',
            'rules_and_restrictions' => 'random_set_of_rules',
            'pricing_scheme' => 'NONE',
            'position' => 0
        ]];
        $postDataJSON = json_encode($postData);

        $this->client->request('POST', self::$apiRoute, [], [], ['CONTENT_TYPE' => 'application/json'], $postDataJSON);
        $response = $this->client->getResponse();

        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_CREATED); // 201

        // Check location header exists
        $this->assertTrue($response->headers->has('Location'));

        // Check location header have path to new resource
        $location = $response->headers->get('Location');
        $this->assertStringMatchesFormat(self::$apiRoute . '/%d', $location);

        // Get created record ID
        $id = substr($location, strrpos($location, "/") + 1);

        // Test the record in database:
        /* @var $dictionary \AppBundle\Entity\Dictionary */
        $dictionary = $this->em->find("AppBundle:Dictionary", $id);
        $this->assertNotEmpty($dictionary);

        // Delete record:
        $this->em->remove($dictionary);
        $this->em->flush();
        $this->em->clear();
    }

    public function testGetDictionariesAction()
    {
        $item1 = new Dictionary();
        $item1->setName("Dict Item One");
        $item1->setRulesAndRestrictions("some_rules_and_restrictions");
        $item1->setPricingScheme("NONE");
        $item1->setPosition(0);

        $item2 = new Dictionary();
        $item2->setName("Dict Item Two");
        $item2->setRulesAndRestrictions("some_other_rules_and_restrictions");
        $item2->setPricingScheme("SOME_SCHEME");
        $item2->setPosition(1);

        // I need method like Codeception has: "I->haveInDatabase()";
        $this->em->persist($item1);
        $this->em->persist($item2);
        $this->em->flush();

        $this->client->request('GET', self::$apiRoute);
        $response = $this->client->getResponse();

        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_OK); // 200

        // Check data exists
        $content = $response->getContent();
        $data = json_decode($content, true);
        $this->assertTrue(isset($data['dictionaries']));

        $items = $data['dictionaries'];
        $names = [];
        foreach ($items as $item) {
            $names[] = $item['name'];
        }

        $this->assertContains("Dict Item One", $names);
        $this->assertContains("Dict Item Two", $names);

        $this->em->remove($item1);
        $this->em->remove($item2);
        $this->em->flush();
    }

    public function testGetDictionaryAction()
    {

        $dic = new Dictionary();
        $dic->setName("Plastic Types");
        $dic->setRulesAndRestrictions("some_rules_and_restrictions");
        $dic->setPricingScheme("NONE");
        $dic->setPosition(1);
        $this->em->persist($dic);
        $this->em->flush();

        $this->client->request("GET", "/api/dictionaries/" . $dic->getId());
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 200);
        $data = json_decode($response->getContent(), true);

        $this->assertEquals($dic->getId(), $data['dictionary']['id']);
        $this->em->remove($dic);
        $this->em->flush();
    }

    public function testPutDictionaryAction()
    {

        $dict = new Dictionary();
        $dict->setName("TestDictOne");
        $dict->setRulesAndRestrictions("some_rules_and_restrictions");
        $dict->setPosition(0);
        $this->em->persist($dict);
        $this->em->flush();
        $this->em->clear();

        $putData = ['dictionary' => [
                'name' => 'TestDictOneEdited',
                'rules_and_restrictions' => 'random_set_of_rules',
                'pricing_scheme' => 'NONE',
                'position' => '1'
            ],
        ];

        $payload = json_encode($putData);
        $this->client->request('PUT', self::$apiRoute . "/{$dict->getId()}", [], [], ['CONTENT_TYPE' => 'application/json'], $payload);
        $response = $this->client->getResponse();

        // Check status code
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode()); // 204

        $dictCopy = $this->em->find("AppBundle:Dictionary", $dict->getId());

        $this->assertEquals($putData['dictionary']['name'], $dictCopy->getName());
        $this->assertEquals($putData['dictionary']['rules_and_restrictions'], $dictCopy->getRulesAndRestrictions());
        $this->assertEquals($putData['dictionary']['pricing_scheme'], $dictCopy->getPricingScheme());
        $this->assertEquals($putData['dictionary']['position'], $dictCopy->getPosition());

        // Delete test record
        $this->em->remove($dictCopy);
        $this->em->flush();
    }

    public function testDeleteDictionaryAction()
    {
        $dict = new Dictionary();
        $dict->setName("TestDictOne");
        $dict->setRulesAndRestrictions("some_rules_and_restrictions");
        $dict->setPosition(0);
        $this->em->persist($dict);
        $this->em->flush();
        $this->em->clear();

        $this->client->request('DELETE', self::$apiRoute . "/{$dict->getId()}");
        $response = $this->client->getResponse();

        // Check status code
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode()); // 204

        $dictCopy = $this->em->find("AppBundle:Dictionary", $dict->getId());
        $this->assertEmpty($dictCopy);
    }

    public function testReorderAction()
    {
        // 1. Create several dictionaries
        $rawElement = [
            'name' => 'dictionary_test_reorder',
            'rules_and_restrictions' => 'random_set_of_rules'
        ];

        $items = array_fill(0, 5, $rawElement);

        foreach ($items as $item) {
            $payload = json_encode(['dictionary' => $item]);
            $this->client->request('POST', self::$apiRoute, [], [], ['CONTENT_TYPE' => 'application/json'], $payload);
            $location = $this->client->getResponse()->headers->get('Location');

            // Remember created items to delete them after test
            if(preg_match('#dictionaries/(\d+)$#', $location, $m)) {
                self::$items[] = $m[1];
            }
        }

        // 2. Get dictionaries
        $this->client->request('GET', self::$apiRoute);
        $response = $this->client->getResponse();
        $content = $response->getContent();
        $items = json_decode($content, true)['dictionaries'];
        // Filter items
        $items = array_filter($items, function ($item) {return $item['name'] == 'dictionary_test_reorder';});
        $this->assertEquals(5, count($items));

        // 3. Reorder dictionaries
        $itemsIDs = array_column($items, "id");
        shuffle($itemsIDs);
        $payload = json_encode(['dictionaries' => $itemsIDs]);
        $url = str_replace('/dictionaries', '/reorder_dictionaries', self::$apiRoute);
        $this->client->request('POST', $url, [], [], ['CONTENT_TYPE' => 'application/json'], $payload);

        // 4. Check the order of dictionaries
        $this->client->request('GET', self::$apiRoute);
        $response = $this->client->getResponse();
        $content = $response->getContent();
        $items = json_decode($content, true)['dictionaries'];
        // Filter items
        $items = array_filter($items, function ($item) {return $item['name'] == 'dictionary_test_reorder';});
        $itemsActualIDs = array_column($items, "id");
        $this->assertEquals($itemsIDs, $itemsActualIDs);
    }

    public function testDictionaryEntryProfileCannotContainDuplicates()
    {
        /** @var EntityManager $em */
        $em = self::$kernel->getContainer()->get('doctrine.orm.default_entity_manager');

        $dict = new Dictionary();
        $dict->setName('test_dictionary');
        $dict->setRulesAndRestrictions('');

        $em->persist($dict);

        $dictEntry = new DictionaryEntry();
        $dictEntry->setName('test_entry');
        $dictEntry->setPosition(1);
        $dictEntry->setData('');
        $dictEntry->setDictionary($dict);

        $em->persist($dictEntry);

        $profile = new Profile();
        $profile->setName('test_profile');

        $em->persist($profile);
        $em->flush();

        $payload = [
            'entry' => [
                'name' => 'test_entry',
                'data' => 'test data',
                'position' => 1,
                'dictionary_entry_profiles' => [
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
                '%s/%d/entries/%d',
                self::$apiRoute,
                $dict->getId(),
                $dictEntry->getId()
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
        $em->remove($dictEntry);
        $em->remove($dict);
        $em->remove($profile);
        $em->flush();
    }

    public function testDeleteDictionaryWithConstraintReferences()
    {
        /** @var EntityManager $em */
        $em = self::$kernel->getContainer()->get('doctrine.orm.default_entity_manager');

        // create test data
        $dict = new Dictionary();
        $dict->setName('test_dictionary');
        $dict->setRulesAndRestrictions('');

        $em->persist($dict);

        $dictEntry = new DictionaryEntry();
        $dictEntry->setName('test_dictionary_entry');
        $dictEntry->setDictionary($dict);
        $dictEntry->setData('');
        $dictEntry->setPosition(1);

        $em->persist($dictEntry);

        $profile = new Profile();
        $profile->setName('test_profile');

        $em->persist($profile);

        $dictEntryProfile = new DictionaryEntryProfile();
        $dictEntryProfile->setEntry($dictEntry);
        $dictEntryProfile->setProfile($profile);

        $em->persist($dictEntryProfile);

        $em->flush();

        $this->client->request('DELETE', sprintf('%s/%d', self::$apiRoute, $dict->getId()));
        $response = $this->client->getResponse();

        $em->clear();

        // Check status code
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode()); // 204

        $this->assertEmpty($em->find("AppBundle:Dictionary", $dict->getId()));
        $this->assertEmpty($em->find("AppBundle:DictionaryEntry", $dictEntry->getId()));
        $this->assertEmpty($em->find("AppBundle:DictionaryEntryProfile", $dictEntryProfile->getId()));

        $em->remove($em->find("AppBundle:Profile", $profile->getId()));
        $em->flush();
    }
}
