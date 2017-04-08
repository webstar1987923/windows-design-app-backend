<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Url;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations;

class PdfController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{
    /**
     * Create new PDF document from chosen pages of origin PDF doc.
     *
     * @ApiDoc(
     *     resource = true,
     *     section = "Pdf section"
     * )
     * @Annotations\QueryParam(name="url", requirements="URL", nullable=false, description="URL of origin PDF document")
     * @Annotations\QueryParam(name="pages", requirements="1,3-5,45", nullable=false, description="Page numbers to extract and merge together")
     *
     * @param Request $request
     * @return array|JsonResponse
     * @throws \Exception
     */
    public function splitAndMergeAction(Request $request)
    {
        $data = [
            'url' => $request->request->get("url"),
            'pages' => $request->request->get("pages")
        ];

        $form = $this->getSplitAndMergeForm($data);

        if ( $form->isValid() ) {

            $data = $form->getData();

            $url = $data['url'];
            $pageNumbers = $data['pages'];

            try {
                $workDir = $this->getWorkDirFor($url);
                $filename  = pathinfo($url, PATHINFO_BASENAME);
                $filename = str_replace('..', '', $filename);
                $fqFilename = $workDir . DIRECTORY_SEPARATOR . $filename;

                file_put_contents($fqFilename, $this->get("app.fetch_remote")->fetch($url));

                $pdfTools = new \Prossimo\PdfTools();

                $result = $pdfTools->splitAndMerge($fqFilename, $pageNumbers);

                $outputDir = $this->container->getParameter('pdf_data_path');
                $outputUri = $this->container->getParameter('pdf_data_url');

                // simple copy $pages['result'] to public dir
                $publicFileName = $outputDir . DIRECTORY_SEPARATOR . $result['filename'];

                copy($result['result'], $publicFileName);

                // collect URLs of each page
                $pdfPagesURLs = [];
                foreach ($result['pages'] as $resultPage) {
                    $resultPageSourceFilename = $resultPage['jpg'];
                    $resultPageDestFilename = $outputDir . DIRECTORY_SEPARATOR . basename($resultPageSourceFilename);
                    copy($resultPageSourceFilename, $resultPageDestFilename);
                    $pdfPagesURLs[] = $outputUri . '/' . basename($resultPageSourceFilename);
                }

                $this->rmdir($workDir);

                $data = [
                    "url" => $outputUri . '/' . $result['filename'],
                    "pages" => $pdfPagesURLs
                ];

                return new JsonResponse($data);

            } catch (\Exception $ex) {
                return new JsonResponse(['error' => $ex->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }

        } else {
            $errors =  $form->getErrors(true);
            return new JsonResponse(['error' => $errors[0]->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Create form object for split_n_megre request
     * @param array $data
     * @return \Symfony\Component\Form\Form
     */
    public function getSplitAndMergeForm($data)
    {
        $form = $this->createFormBuilder($data, ['csrf_protection' => false])
            ->add('url', 'text', [
                'constraints' => [
                    new Url(),
                    new Regex([
                        'pattern' => '/\.pdf$/i',
                        'message' => 'Only .pdf files are allowed'
                    ])
                ]
            ])
            ->add('pages', 'text', [
                'constraints' => new Regex([
                    'pattern' => '/^(\d+-\d+,?|\d+,?)+$/',
                    'message' => 'Invalid `pages` param. It must looks like "1,3,5-10,33"'
                ])
            ])
            ->getForm();

        $form->submit($data);
        return $form;
    }

    /**
     * Extract table from PDF document
     *
     * @ApiDoc(
     *     resource = true,
     *     section = "Pdf section"
     * )
     * @Annotations\QueryParam(name="url", requirements="URL", nullable=false, description="URL of origin PDF document")
     * @Annotations\QueryParam(name="page_number", requirements="\d+", nullable=false, description="Document page number with table on it")
     * @Annotations\QueryParam(name="x", requirements="\d+", nullable=false, description="Offset left")
     * @Annotations\QueryParam(name="y", requirements="\d+", nullable=false, description="Offset top")
     * @Annotations\QueryParam(name="w", requirements="\d+", nullable=false, description="Table width")
     * @Annotations\QueryParam(name="h", requirements="\d+", nullable=false, description="Table height")
     * @Annotations\QueryParam(name="pw", requirements="\d+",nullable=false, description="Document page width")
     *
     * @param Request $request
     * @return array|JsonResponse
     * @throws \Exception
     */
    public function extractTableAction(Request $request)
    {
        // It seems that i should create Form object to validate input data, but i don't know how...

        $data = [
            "url" => $request->request->get("url"),
            "page_number" => $request->request->get("page_number"),
            "x" => $request->request->get("x"),
            "y" => $request->request->get("y"),
            "w" => $request->request->get("w"),
            "h" => $request->request->get("h"),
            "pw" => $request->request->get("pw")
        ];

        $form = $this->getExtractTableForm($data);

        if( $form->isValid() ) {

            $data = $form->getData();
            $url = $data['url'];
            try {
                $workDir = $this->getWorkDirFor($url);

                $filename = pathinfo($url, PATHINFO_BASENAME);
                $filename = str_replace("..", "", $filename);
                $fqFilename = $workDir . DIRECTORY_SEPARATOR . $filename;

                file_put_contents($fqFilename, $this->get("app.fetch_remote")->fetch($url));

                $pdfTools = new \Prossimo\PdfTools();
                $data = $pdfTools->extractTable($fqFilename, $data['page_number'], $data['x'], $data['y'], $data['w'], $data['h'], $data['pw']);

                $this->rmdir($workDir);

                return new JsonResponse($data);
            } catch (\Exception $ex) {
                return new JsonResponse(['error' => $ex->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            $errors =  $form->getErrors(true);
            return new JsonResponse(['error' => $errors[0]->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Create form object for extract_table request
     * @param array $data
     * @return \Symfony\Component\Form\Form
     */
    public function getExtractTableForm($data)
    {
        $form = $this->createFormBuilder($data, ['csrf_protection' => false])
            ->add('url', 'text', [
                'constraints' => [
                    new Url(),
                    new Regex([
                        'pattern' => '/\.pdf$/i',
                        'message' => 'Only .pdf files are allowed'
                    ])
                ]
            ])
            ->add('page_number', 'text', [
                'constraints' => [new NotBlank(), new Type(['type' => 'numeric'])]
            ])
            ->add('x', 'text', [
                'constraints' => [new NotBlank(), new Type(['type' => 'numeric'])]
            ])
            ->add('y', 'text', [
                'constraints' => [new NotBlank(), new Type(['type' => 'numeric'])]
            ])
            ->add('w', 'text', [
                'constraints' => [new NotBlank(), new Type(['type' => 'numeric'])]
            ])
            ->add('h', 'text', [
                'constraints' => [new NotBlank(), new Type(['type' => 'numeric'])]
            ])
            ->add('pw', 'text', [
                'constraints' => [new NotBlank(), new Type(['type' => 'numeric'])]
            ])
            ->getForm()
            ->submit($data);
        return $form;
    }

    private function getWorkDirFor($url){
        $workDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR . str_shuffle(md5($url));
        if ( !file_exists($workDir) ) {
            mkdir($workDir, 0777, true);
        } elseif ( !is_writable($workDir) ) {
            throw new \Exception("Dir '$workDir' is not writable.");
        }
        return $workDir;
    }

    private function rmdir($dirname) {
        $dh = opendir($dirname);
        if($dh) {
            while( $file = readdir($dh) ) {
                if($file != '.' && $file != '..') {
                    $fqFilename = $dirname . DIRECTORY_SEPARATOR . $file;
                    if( is_dir($fqFilename) ) {
                        $this->rmdir($fqFilename);
                    } else {
                        unlink($fqFilename);
                    }
                }
            }
            closedir($dh);
            rmdir($dirname);
        }
    }

}
