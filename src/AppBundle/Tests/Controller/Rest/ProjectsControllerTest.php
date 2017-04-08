<?php

namespace AppBundle\Tests\Controller\Rest;

use AppBundle\Entity\Quote;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group projects
 */
class ProjectsControllerTest extends RestTestCase
{
    private static $apiRoute = '/api/projects';
    private static $resourceId = null;

    public function testPostProjectAction()
    {
        $postResourceData =
            ['project' =>
                [
                    'client_name' => 'Client Test1',
                    'client_company_name' => 'Client Company Test1',
                    'client_phone' => '+1 TEST1 123-456-789',
                    'client_email' => 'client-test1@clientcorp.com',
                    'client_address' => 'Client Test1 address',
                    'project_name' => 'Project Test1',
                    'project_address' => 'Project addr Test1',
                    'quote_date' => '2016-01-01T12:00:00',
                    'quote_revision' => '1',
                    'settings' => 'project_settings_test_1',
                    'frontapp_thread_id' => 'project_frontapp_thread_id_test_1',
                    'frontapp_gdrive_folder_id' => 'project_frontapp_gdrive_folder_id_test_1',
                    'dapulse_pulse_id' => 'dapulse_pulse_id_test_1',
                    'extra_id_data' => 'extra_id_data_test_1',
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
        $this->assertTrue(isset($decoded['project']['id']));

        self::$resourceId = $decoded['project']['id'];
    }

    public function testGetProjectsAction()
    {
        $this->client->request('GET', self::$apiRoute);
        $response = $this->client->getResponse();

        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_OK); // 200

        // Check data exists
        $content = $response->getContent();
        $data = json_decode($content, true);

        $this->assertArrayHasKey("projects", $data);
        $this->assertArrayHasKey("offset", $data);
        $this->assertArrayHasKey("limit", $data);

        // Check visible and hidden fields
        $this->assertArrayHasKey("id", $data["projects"][0]);
        $this->assertArrayNotHasKey("units", $data["projects"][0]);
    }

    public function testGetProjectAction()
    {
        $resourceId = self::$resourceId;

        $this->client->request('GET', self::$apiRoute . "/{$resourceId}");
        $response = $this->client->getResponse();

        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_OK); // 200

        // Check data exists
        $content = $response->getContent();
        $data = json_decode($content, true);
        $this->assertArrayHasKey("project", $data);

        // Check if response contain extra fields like `quotes`
        $this->assertArrayHasKey("id", $data['project']);
        $this->assertArrayHasKey("quotes", $data['project']);

        // Check if it's the same project
        $this->assertEquals($resourceId, $data['project']['id']);
    }

    /**
     * Check that we could get project.units.0.profile.name if project has units and units have profile
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function testGetProjectUnitsProfile() {
        $resourceId = self::$resourceId;

        /* @var $em \Doctrine\ORM\EntityManager */
        $em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        /* @var $project \AppBundle\Entity\Project */
        $project = $em->find('AppBundle:Project', $resourceId);

        if($project) {
            $profile = new \AppBundle\Entity\Profile();
            $profile->setName("TEST_PROFILE");
            $em->persist($profile);
            $em->flush();

            $quote = new Quote();
            $quote->setProject($project);
            $quote->setIsDefault(true);

            $unit = new \AppBundle\Entity\Unit();
            $unit->setMark("UNIT001");
            $unit->setProfile($profile);
            $unit->setQuote($quote);
            $userRepo = $em->getRepository('AppBundle:User');
            $user = $userRepo->findOneBy(['username' => 'admin']);

            $file = array('9e9c4f80-e1e1-4de3-9c3c-cfb986858be4', 'helloworld.pdf', 'application/pdf', 678, 'gaufrette.local_filesystem', 150, 150);

            $bf = new \AppBundle\Entity\BinaryFile();
            $bf->setUuid($file[0]);
            $bf->setFilesystemName($file[0] . '.bin');
            $bf->setHasThumbnail(true);
            $bf->setOriginalName($file[1]);
            $bf->setContentType($file[2]);
            $bf->setSize($file[3]);
            $bf->setFilesystem($file[4]);
            $bf->setThumbnailWidth($file[5]);
            $bf->setThumbnailHeight($file[6]);
            $bf->updateTimestamps();
            $bf->updateAuditFields($user);

            $project->addBinaryFile($bf);


            $accessory = new \AppBundle\Entity\Accessory();
            $accessory->setDescription("PROJECT_TEST_ACCESSORY");
            $accessory->setQuote($quote);

            $project->addQuote($quote);

            $em->persist($project);
            $em->persist($unit);
            $em->persist($accessory);

            $em->flush();
        } else {
            $this->fail("No project");
        }

        $this->client->request('GET', self::$apiRoute . "/{$resourceId}");
        $response = $this->client->getResponse();

        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_OK); // 200

        // Check data exists
        $content = $response->getContent();
        $data = json_decode($content, true);
        $this->assertArrayHasKey("project", $data);

        $project = $data['project'];

        $this->assertArrayHasKey("files", $project);
        $this->assertNotEmpty($project['files']);
        $this->assertArrayHasKey("original_name", $project['files'][0]);
        $this->assertEquals("helloworld.pdf", $project['files'][0]['original_name']);

        $em->remove($unit);
        $em->remove($accessory);
        $em->remove($bf);
        $em->remove($profile);
        $em->remove($quote);
        $em->flush();
    }

    public function testPutProjectAction() // Edit existing
    {
        $resourceId = self::$resourceId;
        // Get previously created resource
        $putResourceData =
            ['project' =>
                [
                    'client_name' => 'Client Test 2',
                    'client_company_name' => 'Client Company Test 2',
                    'client_phone' => '+1 TEST2 123-456-789',
                    'client_email' => 'client-test2@clientcorp.com',
                    'client_address' => 'Client Test2 address',
                    'project_name' => 'Project Test2',
                    'project_address' => 'Project addr Test2',
                    'quote_date' => '2016-01-01T12:00:01',
                    'quote_revision' => '2',
                    'settings' => 'project_settings_test_2',
                    'frontapp_thread_id' => 'project_frontapp_thread_id_test_2',
                    'frontapp_gdrive_folder_id' => 'project_frontapp_gdrive_folder_id_test_2',
                    'dapulse_pulse_id' => 'dapulse_pulse_id_test_2',
                    'extra_id_data' => 'extra_id_data_test_2',
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
        $this->assertEquals($resourceId, $decoded['project']['id']);

        // Check every field updated value
        foreach ($putResourceData['project'] as $key => $value) {
            $this->assertEquals($value, $decoded['project'][$key]);
        }
    }

    public function testDeleteProjectAction()
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
}
