<?php

namespace AppBundle\Controller\Rest;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Doctrine\ORM\EntityManager;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use FOS\RestBundle\View\RouteRedirectView;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;

use AppBundle\Entity\Project;
use AppBundle\Form\ProjectType;
use AppBundle\Form\ProjectFilesType;

use AppBundle\Entity\Quote;

/**
 * Rest controller for projects
 */
class ProjectsController extends FOSRestController
{
    /**
     * List all projects
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   },
     *   section = "Projects section"
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing projects.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="10", description="How many projects to return.")
     *
     * @Annotations\View(serializerGroups={"list"})
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getProjectsAction(Request $request, ParamFetcherInterface $paramFetcher) // "get_projects" [GET] /api/projects
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        $limit = 0 == $limit ? null : $limit; // when 0 - then  unlimited
        $projects = $this->getDoctrine()->getManager()->getRepository('AppBundle:Project')->findBy([], null, $limit, $offset);

        // Using simple array instead of ProjectCollection because JMSSerializer can't read annotations of it and
        return ["projects" => $projects, "offset" => $offset, "limit" => $limit];
    }

    /**
     * Get a single project.
     *
     * @ApiDoc(
     *   output = "AppBundle\Entity\Project",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the project is not found"
     *   },
     *   section = "Projects section"
     * )
     *
     * @Annotations\View(templateVar="project", serializerGroups={"Default", "project-details"})
     *
     * @param Request $request the request object
     * @param int $project_id the project id
     *
     * @return array
     *
     * @throws NotFoundHttpException when project not exist
     */
    public function getProjectAction(Request $request, $project_id) // "get_project" [GET] /api/projects/{project_id}
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('AppBundle:Project')->getProject($project_id);
        if(empty($project)) {
            throw new NotFoundHttpException("Project not found");
        }

        return ['project' => $project];
    }

    /**
     * Creates a new project from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ProjectType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Projects section"
     * )
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface[]|View
     */
    public function postProjectsAction(Request $request) // "post_projects"     [POST] /api/projects
    {
        $model = new Project();
        $form = $this->createForm(new ProjectType(), $model);
        $form->submit($request);

        if ($form->isValid()) {
            if (!$model->getProjectNotes()) {
                $model->setProjectNotes('');
            }

            if (!$model->getShippingNotes()) {
                $model->setShippingNotes('');
            }

            //  Add a default Quote on Project creation
            $default_quote = new Quote();
            $default_quote->setIsDefault(true);
            $model->addQuote($default_quote);
            $default_quote->setProject($model);

            $em = $this->getDoctrine()->getManager();
            $em->persist($model);

            if ($form->has('files')) {
                $pfm = $this->get('app.manager.project_file');
                $pfm->updateProjectFiles($model, $form->get('files')->getData());
            }

            $em->flush();
            return $this->routeRedirectView('get_project', ['project_id' => $model->getId()]);
        }
        return [
            'form' => $form
        ];
    }

    /**
     * Update existing project from the submitted data or create a new project at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ProjectType",
     *   statusCodes = {
     *     201 = "Returned when a new resource is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Projects section"
     * )
     *
     * @param Request $request the request object
     * @param int $project_id the project id
     *
     * @return FormTypeInterface|RouteRedirectView
     *
     * @throws NotFoundHttpException when project not exist
     */
    public function putProjectAction(Request $request, $project_id) // "put_project"      [PUT] /api/projects/{project_id}
    {
        $model = $this->getDoctrine()->getRepository('AppBundle:Project')->find($project_id);

        if (!$model instanceof Project) {
            $model = new Project();
            $model->setId($project_id);
            $statusCode = Response::HTTP_CREATED;
        } else {
            $statusCode = Response::HTTP_NO_CONTENT;
        }
        $form = $this->createForm(new ProjectType(), $model);
        $form->submit($request);
        if ($form->isValid()) {
            if (!$model->getProjectNotes()) {
                $model->setProjectNotes('');
            }
            if (!$model->getShippingNotes()) {
                $model->setShippingNotes('');
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($model);

            if ($form->has('files')) {
                $pfm = $this->get('app.manager.project_file');
                $pfm->updateProjectFiles($model, $form->get('files')->getData());
            }

            $em->flush();
            return $this->routeRedirectView('get_projects', array('id' => $model->getId()), $statusCode);
        }
        return $form;
    }

    /**
     * Update the files that are linked to a Project
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ProjectFilesType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Projects section"
     * )
     *
     * @param Request $request the request object
     * @param int     $project_id the project id
     *
     * @return FormTypeInterface|RouteRedirectView
     *
     * @throws NotFoundHttpException when project not exist
     */
    public function putProjectFilesAction(Request $request, $project_id) // "put_project_files"      [PUT] /api/projects/{project_id}/files
    {
        if (!$project = $this->getDoctrine()->getRepository('AppBundle:Project')->find($project_id)) {
            throw new NotFoundHttpException('Project not found');
        }

        $form = $this->createForm(new ProjectFilesType(), $project);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if ($form->has('files')) {
                $pfm = $this->get('app.manager.project_file');
                $pfm->updateProjectFiles($project, $form->get('files')->getData());
            }

            $em->flush();
            return $this->routeRedirectView('get_projects', array('id' => $project->getId()), Response::HTTP_NO_CONTENT);
        }

        return $form;
    }

    /**
     * Removes a project.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   },
     *   section = "Projects section"
     * )
     *
     * @param Request $request the request object
     * @param int $project_id the project id
     *
     * @return View
     */
    public function deleteProjectsAction(Request $request, $project_id) // "delete_project"   [DELETE] /api/projects/{project_id}
    {
        $project = $this->getDoctrine()->getRepository('AppBundle:Project')->find($project_id);

        if ($project instanceof Project) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($project);
            $em->flush();
        }
        // There is a debate if this should be a 404 or a 204
        // see http://leedavis81.github.io/is-a-http-delete-requests-idempotent/
        return $this->routeRedirectView('get_projects', [], Response::HTTP_NO_CONTENT);
    }

    /**
     * Removes a project.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   },
     *   section = "Projects section"
     * )
     *
     * @param Request $request the request object
     * @param int $project_id the project id
     *
     * @return View
     */
    public function removeProjectsAction(Request $request, $project_id) // "remove_project"   [GET] /api/projects/{project_id}/remove
    {
        return $this->deleteProjectsAction($request, $project_id);
    }
}
