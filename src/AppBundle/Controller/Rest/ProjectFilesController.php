<?php

namespace AppBundle\Controller\Rest;

use Symfony\Component\HttpFoundation\Request;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;

use AppBundle\Helpers\ProjectHelper;

/**
 * Rest controller for files
 *
 * @package AppBundle\Controller
 */
class ProjectFilesController extends FOSRestController
{
    /**
     * List all ProjectFiles
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   },
     *   section = "Project Files section"
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing files.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="10", description="How many files to return.")
     *
     * @Annotations\View(serializerGroups={"Default"})
     *
     * @param Request $request the request object
     * @param int $project_id the project id
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getFilesAction(Request $request, ParamFetcherInterface $paramFetcher, $project_id) // "get_projects_files" [GET] /api/projects/{project_id}/files
    {
        $toReturn = array(); //array to return as JSON

        $em = $this->getDoctrine()->getManager();
        ProjectHelper::getProjectByIdOrThrowNotFoundHttpException($em, $project_id);
        $project = $em->getRepository('AppBundle:Project')->findOneBy(['id' => $project_id]);

        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        $limit = 0 == $limit ? null : $limit; // when 0 - then  unlimited

        foreach ($project->getBinaryFiles() as $binaryFile) {
            $toReturn[] = $binaryFile;
        }

        return [
            "files" => array_slice($toReturn, $offset, $limit),
            "offset" => $offset,
            "limit" => $limit
        ];
    }
}
