<?php

namespace AppBundle\Tests\Controller\Rest;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Doctrine\ORM\EntityManager;

use Gaufrette\Filesystem;

use AppBundle\Entity\BinaryFile;
use AppBundle\Helpers\UuidHelper;
use AppBundle\Manager\FilesManager;

class FilesControllerTest extends RestTestCase
{
    private static $apiRoute = '/api/files';
    private static $resourceId = null;
    private static $uploadFilename = 'test-smile-256x256.png';
    private static $uploadContentType = 'image/png';

    public static function tearDownAfterClass() {
        //self::bootKernel();
        //$fs = static::$kernel->getContainer()->get('gaufrette.temp_filesystem');
        // $fs->delete();
        parent::tearDownAfterClass();
    }

    // TestScenario:
    //  1. Upload file (BinaryData)
    //  2. Get all files (MetaData)
    //  3. Get uploaded file (MetaData)
    //  4. Download file (BinaryData)
    //  TODO: 5. Update file (MetaData)
    //  6. Delete file
    //  7. Remove file

    private function uploadFile() {
        $apiEndpoint = self::$apiRoute;
        $filename = self::$uploadFilename;
        $filepath = __DIR__ . '/TestData/' . $filename;
        $filesize = filesize($filepath);

        $file = new UploadedFile(
            $filepath,
            self::$uploadFilename,
            self::$uploadContentType,
            $filesize
        );

        $files = [];
        $files['file'] = $file;
        $this->client->request('POST', $apiEndpoint, [], $files, ['CONTENT_TYPE' => 'multipart/form-data'], null);
        $response = $this->client->getResponse();
        return $response;
    }

    public function testInvalidUuidReturns404()
    {
        $this->client->request('GET', sprintf('%s/1', self::$apiRoute));
        $response = $this->client->getResponse();

        // Check status code equals 404
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testPostFilesUploadAction() {
        $response = $this->uploadFile();

        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_CREATED); // 201

        // Check location header exists
        $this->assertTrue($response->headers->has('Location'));

        // Check location header have path to new resource
        $location = $response->headers->get('Location');
        $this->assertStringMatchesFormat(self::$apiRoute . '/%s', $location);

        // Get new resource
        $this->client->request('GET', $location);
        $response = $this->client->getResponse();
        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_OK); // 200
        // Check data exists
        $content = $response->getContent();
        $decoded = json_decode($content, true);
        $this->assertTrue(isset($decoded['file']['uuid']));

        self::$resourceId = $decoded['file']['uuid'];
    }


    public function testGetFilesAction()
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

    public function testGetFileAction()
    {
        $resourceId = self::$resourceId;

        $this->client->request('GET', self::$apiRoute . "/{$resourceId}");
        $response = $this->client->getResponse();

        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_OK); // 200

        // Check data exists
        $content = $response->getContent();
        $decoded = json_decode($content, true);
        $this->assertEquals($resourceId, $decoded['file']['uuid']);
    }

    public function testGetFilesDownloadAction()
    {
        $resourceId = self::$resourceId;

        $this->client->request('GET', self::$apiRoute . "/{$resourceId}/download");
        $response = $this->client->getResponse();

        // Check status code
        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK); // 200

        // Check headers
        $this->assertTrue($response->headers->has('Content-Type'));
        $contentType = $response->headers->get('Content-Type');
        $this->assertEquals(self::$uploadContentType, $contentType);

        $this->assertTrue($response->headers->has('Content-Disposition'));
        $contentDisposition = $response->headers->get('Content-Disposition');
        $expectedContentDisposition = 'inline; filename=' . self::$uploadFilename;
        $this->assertEquals($expectedContentDisposition, $contentDisposition);
    }

    public function testGetFilesThumbnailAction()
    {
        /** @var EntityManager $em */
        $em = self::$kernel->getContainer()->get('doctrine.orm.default_entity_manager');

        $testFilename = 'test-pdf.pdf';
        $testFile = __DIR__ . '/TestData/' . $testFilename;

        $uuid = UuidHelper::NewUuid();

        $filename = $uuid . FilesManager::BINARY_EXTENSION;

        /** @var Filesystem $tempFs */
        $tempFs = self::$kernel->getContainer()->get('gaufrette.temp_filesystem');

        $tempFs->write($filename, file_get_contents($testFile));

        $this->writePdfThumbnail($uuid, $tempFs);


        $bf = new BinaryFile();
        $bf->setUuid($uuid);
        $bf->setFilesystem('gaufrette.temp_filesystem');
        $bf->setFilesystemName($filename);
        $bf->setOriginalName($testFilename);
        $bf->setHasThumbnail(true);
        $bf->setContentType($tempFs->mimeType($filename));
        $bf->setSize($tempFs->size($filename));
        $bf->updateAuditFields($em->getRepository('AppBundle:User')->findOneBy(['username' => 'admin']));
        $bf->updateTimestamps();

        $serializer = self::$kernel->getContainer()->get('jms_serializer');

        $tempFs->write($uuid . FilesManager::METADATA_EXTENSION, $serializer->serialize($bf, 'json'));

        $this->client->request('GET', self::$apiRoute . "/{$uuid}/thumbnail");
        $response = $this->client->getResponse();

        // Check status code
        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK); // 200

        // Check headers
        $this->assertTrue($response->headers->has('Content-Type'));
        $contentType = $response->headers->get('Content-Type');
        $this->assertEquals($tempFs->mimeType($uuid . '-thumbnail' . FilesManager::BINARY_EXTENSION), $contentType);

        $this->assertTrue($response->headers->has('Content-Disposition'));
        $contentDisposition = $response->headers->get('Content-Disposition');
        $expectedContentDisposition = 'inline; filename=test-pdf-thumb.jpg';
        $this->assertEquals($expectedContentDisposition, $contentDisposition);

        $tempFs->delete($filename);
        $tempFs->delete($uuid . '-thumbnail' . FilesManager::BINARY_EXTENSION);
        $tempFs->delete($uuid . FilesManager::METADATA_EXTENSION);
    }

    public function testDeleteFileAction()
    {
        $resourceId = self::$resourceId;

        $this->client->request('DELETE', self::$apiRoute . "/{$resourceId}");
        $response = $this->client->getResponse();

        // Check status code
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode()); // 204

        // Try to get resource
        $this->client->request('GET', self::$apiRoute . "/{$resourceId}");
        $response = $this->client->getResponse();

        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_NOT_FOUND); // 404
    }

    public function testRemoveFileAction()
    {
        $response = $this->uploadFile();
        $location = $response->headers->get('Location');

        $lastSlashPos = strrpos($location, '/');
        $resourceId = substr($location, ++$lastSlashPos);

        $this->client->request('GET', self::$apiRoute . "/{$resourceId}/remove");
        $response = $this->client->getResponse();

        // Check status code
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode(), 'Location:' . $location . ' ResID:' . $resourceId); // 204

        // Try to get resource
        $this->client->request('GET', self::$apiRoute . "/{$resourceId}");
        $response = $this->client->getResponse();

        // Check status code
        $this->assertJsonResponse($response, Response::HTTP_NOT_FOUND); // 404
    }

    /**
     * Temporary, until thumbnails are created on file upload
     *
     * @param string     $uuid
     * @param Filesystem $tempFs
     */
    private function writePdfThumbnail($uuid, Filesystem $tempFs)
    {
        $settingsEntity = self::$kernel
            ->getContainer()
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository('AppBundle:AppSetting')
            ->findBy(array('group_name' => 'thumbnails'), array('id' => 'ASC'))
        ;

        $settings = array();
        foreach ($settingsEntity as $setting) {
            $settings[$setting->getSystemName()] = $setting->getValue();
        }

        $pdfHelper = self::$kernel->getContainer()->get('helpers.pdfhelper');
        $imageHelper = self::$kernel->getContainer()->get('helpers.imagehelper');
        $tempDirectory = self::$kernel->getContainer()->getParameter('prossimo_server_files_temp_directory');

        $tempFs->write($uuid . '.pdf', $tempFs->read($uuid . FilesManager::BINARY_EXTENSION));

        $pdfHelper::createPdfThumbnail($tempDirectory, $uuid);

        //resize thumbnail
        $imageHelper->resizeImage(
            $tempDirectory . '/' . $uuid . '.jpg',
            $tempDirectory . '/',
            $uuid . '-thumbnail',
            $settings['thumbnails_height'],
            $settings['thumbnails_width'],
            (bool)$settings['thumbnails_save_ratio'],
            $settings['thumbnails_quality']);

        $tempFs->write($uuid . '-thumbnail.bin', $tempFs->read($uuid . '-thumbnail.jpg'));
        $tempFs->delete($uuid . '.jpg');
        $tempFs->delete($uuid . '-thumbnail.jpg'); //delete image-extension thumbnail
        $tempFs->delete($uuid . '.pdf'); //delete image-extension thumbnail
    }

//
//    public function testPutFileAction() // Edit existing
//    {
//        $resourceId = self::$resourceId;
//        // Get previously created resource
//        $putResourceData =
//            ['file' =>
//                [
//                    'name' => 'project_file_name_test2',
//                    'type' => 'project_file_type_test2',
//                    'url' => 'project_file_url_test2'
//                ],
//            ];
//
//        $payload = json_encode($putResourceData);
//        $this->client->request('PUT', self::$apiRoute . "/{$resourceId}", [], [], ['CONTENT_TYPE' => 'application/json'], $payload);
//        $response = $this->client->getResponse();
//
//        // Check status code
//        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode()); // 204
//
//        // Get updated resource
//        $this->client->request('GET', self::$apiRoute . "/{$resourceId}");
//        $response = $this->client->getResponse();
//        // Check status code
//        $this->assertJsonResponse($response, Response::HTTP_OK); // 200
//        // Check data exists
//        $content = $response->getContent();
//        $decoded = json_decode($content, true);
//        $this->assertEquals($resourceId, $decoded['file']['uuid']);
//
//        // Check every field updated value
//        foreach ($putResourceData['file'] as $key => $value) {
//            $this->assertEquals($value, $decoded['file'][$key]);
//        }
//    }
//

}
