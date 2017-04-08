<?php

namespace AppBundle\Controller\Rest;

use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\RouteRedirectView;

use JMS\Serializer\SerializationContext;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Gaufrette\Exception\FileNotFound;

use AppBundle\Helpers\UuidHelper;
use AppBundle\Helpers\ParamFetcherHelper;
use AppBundle\Entity\BinaryFile;
use AppBundle\Form\BinaryFileType;
use AppBundle\Manager\FilesManager;
use AppBundle\Form\FileUploadType;

/**
 * Rest controller for Files
 */
class FilesController extends FOSRestController
{
    /**
     * List all Files
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   },
     *   section = "Files section"
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing profiles.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="10", description="How many profiles to return.")
     *
     * @Annotations\View(serializerGroups={"Default"})
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getFilesAction(Request $request, ParamFetcherInterface $paramFetcher) // "get_files" [GET] /api/files
    {
        list($limit, $offset) = ParamFetcherHelper::getLimitAndOffset($paramFetcher);

        $files = $this->getDoctrine()->getManager()->getRepository('AppBundle:BinaryFile')->findBy([], ['updatedAt' => 'DESC'], $limit, $offset);
        return ['files' => $files, 'offset' => $offset, 'limit' => $limit];
    }


    /**
     * Get a single File
     *
     * @ApiDoc(
     *   output = "AppBundle\Entity\BinaryFileType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the fillingType is not found"
     *   },
     *   section = "Files section"
     * )
     *
     * @Annotations\View(templateVar="binaryFileType", serializerGroups={"Default"})
     *
     * @param Request $request the request object
     * @param string $uuid the File uuid
     *
     * @return array
     *
     * @throws NotFoundHttpException when fillingType not exist
     */
    public function getFileAction(Request $request, $uuid) // "get_file" [GET] /api/files/{uuid}
    {
        if (!UuidHelper::isValidUuid($uuid)) {
            throw new NotFoundHttpException('File not found');
        }

        // Try to find file metadata in Regular storage (DB)
        $entity = $this->getDoctrine()->getRepository('AppBundle:BinaryFile')->find($uuid);
        if ($entity instanceof BinaryFile) {
            // TODO: Check if BinaryContent really exists in Filesystem
            return ['file' => $entity];
        }

        // Try to get file metadata from temp filesystem if not found in DB
        $filesystem = $this->container->get('gaufrette.temp_filesystem');
        // $filename = $uuid . '.bin';
        $filemeta = $uuid . '.meta';
        try {
            $filemetadata = json_decode($filesystem->read($filemeta), true); // Can throw Exception
            return ['file' => $filemetadata];
        } catch (FileNotFound $e) {
            throw new NotFoundHttpException('File not found');
        } catch (\Exception $e) {
            // TODO: log $e
            throw new HttpException('Some error occured: ' . $e->getMessage());
        }
    }


    /**
     * Update existing File from the submitted data or create a new File at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\BinaryFileType",
     *   statusCodes = {
     *     201 = "Returned when a new resource is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Files section"
     * )
     *
     * @Annotations\View(
     *   template="AppBundle:Project:edit.html.twig",
     *   templateVar="form"
     * )
     *
     * @param Request $request the request object
     * @param string $uuid the file uuid
     *
     * @return FormTypeInterface|RouteRedirectView
     *
     */
    public function putFileAction(Request $request, $uuid) // "put_file"      [PUT] /api/files/{uuid}
    {
        if (!UuidHelper::isValidUuid($uuid)) {
            throw new NotFoundHttpException('File not found');
        }

        $entity = $this->getDoctrine()->getRepository('AppBundle:BinaryFile')->find($uuid);

        if (!$entity instanceof BinaryFile) {
            $entity = new BinaryFile();
            $entity->setUuid($uuid);
            $statusCode = Response::HTTP_CREATED;
        } else {
            $statusCode = Response::HTTP_NO_CONTENT;
        }
        $form = $this->createForm(new BinaryFileType(), $entity);
        $form->submit($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->routeRedirectView('get_file', ['uuid' => $uuid], $statusCode);
        }
        return $form;
    }

    /**
     * Removes a File.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   },
     *   section = "Files section"
     * )
     *
     * @param Request $request the request object
     * @param string $uuid the file uuid
     *
     * @return View
     */
    public function deleteFilesAction(Request $request, $uuid) // "delete_files"   [DELETE] /api/files/{uuid}
    {
        if (!UuidHelper::isValidUuid($uuid)) {
            throw new NotFoundHttpException('File not found');
        }

        $entity = $this->getDoctrine()->getRepository('AppBundle:BinaryFile')->find($uuid);

        if ($entity instanceof BinaryFile) {
            $em = $this->getDoctrine()->getManager();

            $fs = $entity->getFilesystem();
            $filesystem = $this->container->get($fs);
            $filesystem->delete($entity->getFilesystemName());

            $em->remove($entity);
            $em->flush();

            return $this->routeRedirectView('get_files', [], Response::HTTP_NO_CONTENT);
        }

        // Check temp
        // Try to get file metadata from temp filesystem if not found in DB
        $filesystem = $this->container->get('gaufrette.temp_filesystem');
        $filename = $uuid . '.bin';
        $filemeta = $uuid . '.meta';
        try {
            $filesystem->delete($filename); // delete binary
            $filesystem->delete($filemeta); // delete metadata
            return $this->routeRedirectView('get_files', [], Response::HTTP_NO_CONTENT);
        } catch (FileNotFound $e) {
            throw new NotFoundHttpException('File not found');
        } catch (\Exception $e) {
            // TODO: log $e
            throw new HttpException('Some error occured: ' . $e->getMessage());
        }

        // There is a debate if this should be a 404 or a 204
        // see http://leedavis81.github.io/is-a-http-delete-requests-idempotent/
    }

    /**
     * Removes a File.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   },
     *   section = "Files section"
     * )
     *
     * @param Request $request the request object
     * @param string $uuid the file uuid
     *
     * @return View
     */
    public function removeFilesAction(Request $request, $uuid) // "remove_files"   [GET] /api/files/{uuid}/remove
    {
        return $this->deleteFilesAction($request, $uuid);
    }

    /**
     * Save Uploaded File into temporary storage from the submitted data
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Files section"
     * )
     *
     * @Annotations\View()
     *
     * @param Request $request the request object
     *
     * @return mixed
     */
    public function postFilesAction(Request $request) // "post_files" [POST] /api/files
    {
        $filesystem = $this->container->get('gaufrette.temp_filesystem');
        $uuid = UuidHelper::NewUuid();

        if ($request->server->get('CONTENT_TYPE') == 'application/json') {
            $form = $this->createForm(new FileUploadType());

            $form->handleRequest($request);

            if ($form->isValid()) {
                $url = $form['url']->getData();
                $headers = $form['headers']->getData();

                $fm = $this->get('app.manager.files');

                try {
                    $tmpFilePath = $fm->downloadFromUrl($url, $headers);
                } catch (\Exception $e) {
                    throw new HttpException(Response::HTTP_BAD_REQUEST, 'File could not be download.');
                }

                $originalFilename = $uuid;
            } else {
                return $form;
            }
        } else if (strpos($request->server->get('CONTENT_TYPE'), 'multipart/form-data') === 0) {
            $file = $request->files->get('file');

            if ($file instanceof UploadedFile) {
                $tmpFilePath = $file->getPathname();
                $originalFilename = $file->getClientOriginalName();
            } else {
                throw new HttpException(Response::HTTP_BAD_REQUEST, 'File upload exception.');
            }
        } else {
            throw new UnsupportedMediaTypeHttpException();
        }

        $filename = $uuid . '.bin';
        $filemeta = $uuid . '.meta';

        $fileContents = file_get_contents($tmpFilePath);
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $fileMimetype = $finfo->file($tmpFilePath);
        $fileSize = filesize($tmpFilePath);

        $filesystem->write($filename, $fileContents);

        $bf = new BinaryFile();
        $bf->setUuid($uuid);
        $bf->setOriginalName($originalFilename);
        $bf->setFilesystemName($filename);
        $bf->setContentType($fileMimetype);
        $bf->setSize($fileSize);
        $bf->setFilesystem('gaufrette.temp_filesystem');
        $bf->updateTimestamps();
        $bf->updateAuditFields($this->getUser());

        $serializer = $this->container->get('jms_serializer');
        $filesystem->write($filemeta, $serializer->serialize($bf, 'json'));

        $view = $this->view(
            ['file' => $bf],
            201,
            ['Location' => $this->generateUrl('get_file', ['uuid' => $uuid])]
        );

        $view->setSerializationContext(SerializationContext::create()->setGroups(['Default']));
        return $this->handleView($view);
    }

    /**
     * Save Uploaded File into temporary storage from the submitted data
     * Special endpoint for JQueryFileUpload
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Files section"
     * )
     *
     * @param Request $request the request object
     * @return Response
     */
    public function postFilesHandlerAction(Request $request) // "post_files_handlers" [POST] /api/files/handlers
    {
        $files = $request->files->get('files');
        $file = $files[0];

        if ($file instanceof UploadedFile) {
            $filesystem = $this->container->get('gaufrette.temp_filesystem');
            $imageHelper = $this->container->get('helpers.imagehelper');
            $pdfHelper = $this->container->get('helpers.pdfhelper');

            $uuid = UuidHelper::NewUuid();
            $filename = $uuid . '.bin';
            $filemeta = $uuid . '.meta';

            $filesystem->write($filename, file_get_contents($file->getPathname()));

            $bf = new BinaryFile();
            $thumbnailDetails = null;

            //if uploaded file is image - then we need to make a thumbnail
            //every thumbnail will have name 'uuid-thumbnail' (e.g. ac2ac7b3-0589-4bf3-a20f-18e68b21c338-thumbnail)
            if ($imageHelper::isImage($file->getClientOriginalExtension())) {
                $settingsEntity = $this->getDoctrine()->getManager()->getRepository('AppBundle:AppSetting')
                    ->findBy(array('group_name' => 'thumbnails'), array('id' => 'ASC'));
                $settings = array();
                foreach ($settingsEntity as $setting) {
                    $settings[$setting->getSystemName()] = $setting->getValue();
                }
                $imageName = $uuid . '.' . $file->getClientOriginalExtension();
                $tempDirectory = $this->container->getParameter('prossimo_server_files_temp_directory');
                //write original-size image
                $filesystem->write($imageName, file_get_contents($file->getPathname()));
                //create thumbnail
                $imageHelper->resizeImage(
                    $tempDirectory . '/' . $imageName,
                    $tempDirectory . '/',
                    $uuid . '-thumbnail',
                    $settings['thumbnails_height'],
                    $settings['thumbnails_width'],
                    (bool)$settings['thumbnails_save_ratio'],
                    $settings['thumbnails_quality']);
                //get precise height and width
                $thumbnailDetails = $imageHelper::getImageDetails($tempDirectory . '/' . $uuid . '-thumbnail.' . $file->getClientOriginalExtension());
                // create .bin thumbnail
                $filesystem->write($uuid . '-thumbnail.bin', $filesystem->read($uuid . '-thumbnail.' . $file->getClientOriginalExtension()));
                $filesystem->delete($imageName); //delete original-size image
                $filesystem->delete($uuid . '-thumbnail.' . $file->getClientOriginalExtension()); //delete image-extension thumbnail
                $bf->setHasThumbnail(true);
            }

            //if uploaded file is pdf
            if ($pdfHelper::isPdf($file->getClientOriginalExtension())) {
                $settingsEntity = $this->getDoctrine()->getManager()->getRepository('AppBundle:AppSetting')
                    ->findBy(array('group_name' => 'thumbnails'), array('id' => 'ASC'));
                $settings = array();
                foreach ($settingsEntity as $setting) {
                    $settings[$setting->getSystemName()] = $setting->getValue();
                }
                $pdfName = $uuid . '.' . $file->getClientOriginalExtension();
                $tempDirectory = $this->container->getParameter('prossimo_server_files_temp_directory');
                $filesystem->write($pdfName, file_get_contents($file->getPathname()));
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
                //get precise height and width
                $thumbnailDetails = $imageHelper::getImageDetails($tempDirectory . '/' . $uuid . '-thumbnail.jpg');
                $filesystem->write($uuid . '-thumbnail.bin', $filesystem->read($uuid . '-thumbnail.jpg'));
                $filesystem->delete($uuid . '.jpg');
                $filesystem->delete($uuid . '-thumbnail.jpg'); //delete image-extension thumbnail
                $filesystem->delete($uuid . '.pdf'); //delete image-extension thumbnail
                $bf->setHasThumbnail(true);
            }


            $bf->setUuid($uuid);
            $bf->setOriginalName($file->getClientOriginalName());
            $bf->setFilesystemName($filename);
            $bf->setContentType($file->getClientMimeType());
            $bf->setSize($file->getClientSize());
            $bf->setFilesystem('gaufrette.temp_filesystem');
            $bf->updateTimestamps();
            $bf->updateAuditFields($this->getUser());
            $thumbnailDetails ? $bf->setThumbnailWidth($thumbnailDetails->width)->setThumbnailHeight($thumbnailDetails->height) : null;

            $serializer = $this->container->get('jms_serializer');
            $filesystem->write($filemeta, $serializer->serialize($bf, 'json'));

            $serialized = $serializer->serialize(
                ['file' => $bf],
                'json',
                SerializationContext::create()->setGroups(['Default'])
            );

            return new Response($serialized);
        }

        throw new HttpException(Response::HTTP_BAD_REQUEST, 'File upload exception.');
    }

    /**
     * Download a File.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   },
     *   section = "Files section"
     * )
     *
     * @param string $uuid the file uuid
     *
     * @return mixed
     */
    public function getFilesDownloadAction($uuid) // "get_files_download" [GET] /api/files/{uuid}/download
    {
        return $this->getFileForDownload($uuid);
    }

    /**
     * Download a File Thumbnail.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     200="Returned when successful"
     *   },
     *   section = "Files section"
     * )
     *
     * @param  string $uuid
     * @return Response
     */
    public function getFilesThumbnailAction($uuid) // "get_files_thumbnail" [GET] /api/files/{uuid}/thumbnail
    {
        return $this->getFileForDownload($uuid, $useThumbnail = true);
    }

    /**
     * @param  string $uuid
     * @param  bool   $useThumbnail
     * @return Response
     */
    private function getFileForDownload($uuid, $useThumbnail = false)
    {
        if (!UuidHelper::isValidUuid($uuid)) {
            throw new NotFoundHttpException('File not found');
        }

        if (!$binaryFile = $this->getDoctrine()->getRepository('AppBundle:BinaryFile')->findOneBy(['uuid' => $uuid])) {
            // not found in database, check filesystem

            $filemeta = $uuid . FilesManager::METADATA_EXTENSION;

            $filesystem = $this->get('gaufrette.temp_filesystem');

            if ($filesystem->has($filemeta)) {
                $serializer = $this->get('jms_serializer');
                $binaryFile = $serializer->deserialize($filesystem->read($filemeta), BinaryFile::class, 'json');
            }
        }

        if ($binaryFile instanceof BinaryFile) {
            $filesystem = $this->get($binaryFile->getFilesystem());

            $filesystemName = $useThumbnail === true
                ? $binaryFile->getThumbnail() . FilesManager::BINARY_EXTENSION
                : $binaryFile->getFilesystemName()
            ;

            if ($filesystem->has($filesystemName)) {
                $filename = $binaryFile->getOriginalName();

                if ($useThumbnail === true) {
                    // remove original extension and replace with
                    // the thumbnail extension
                    $originalExt = '.' . ExtensionGuesser::getInstance()->guess($binaryFile->getContentType());

                    if ($extPos = strrpos($filename, $originalExt)) {
                        $filename = substr_replace($filename, '', $extPos, strlen($filename));
                    }

                    $thumbExt = ExtensionGuesser::getInstance()->guess($filesystem->mimeType($filesystemName));
                    $thumbExt = str_replace('jpeg', 'jpg', $thumbExt);

                    $filename .= '-thumb';

                    if ($thumbExt) {
                        $filename .= '.' . $thumbExt;
                    }
                }

                $headers = [
                    'Content-Type' => $filesystem->mimeType($filesystemName),
                    'Content-Disposition' => sprintf(
                        'inline; filename=%s',
                        urlencode($filename)
                    ),
                ];

                return new Response($filesystem->read($filesystemName), 200, $headers);
            }
        }

        throw new NotFoundHttpException('File not found');
    }
}
