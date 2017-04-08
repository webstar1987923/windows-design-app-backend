<?php

namespace AppBundle\Controller\Rest;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Request\ParamFetcherInterface;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\Accessory;
use AppBundle\Form\AccessoryType;
use AppBundle\Model\AccessoryCollection;

/**
 * Class ProjectQuotesAccessoriesController
 */
class ProjectQuotesAccessoriesController extends FOSRestController
{
    /**
     * List all accessories
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   },
     *   section = "Quote Accessories section"
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", default="0", nullable=true, description="Offset from which to start listing units.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="10", description="How many units to return.")
     *
     * @Annotations\View(serializerEnableMaxDepthChecks=true)
     *
     * @param  ParamFetcherInterface $paramFetcher
     * @param  int                   $project_id
     * @param  int                   $quote_id
     * @return AccessoryCollection
     */
    public function getAccessoriesAction(ParamFetcherInterface $paramFetcher, $project_id, $quote_id) // "get_projects_quote_accessories" [GET] /api/projects/{project_id}/quotes/{quote_id}/accessories
    {
        $em = $this->getDoctrine()->getManager();

        if (!($project = $em->getRepository('AppBundle:Project')->find($project_id))) {
            throw new NotFoundHttpException('Project not found');
        }

        if (!($quote = $em->getRepository('AppBundle:Quote')->find($quote_id))) {
            throw new NotFoundHttpException('Quote not found');
        }

        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');

        $accessories = $em->getRepository('AppBundle:Accessory')->findBy(['quote' => $quote], ['position' => 'ASC'], $limit, $offset);
        return new AccessoryCollection($accessories, $offset, $limit);
    }

    /**
     * Get a single accessory.
     *
     * @ApiDoc(
     *   output = "AppBundle\Entity\Accessory",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the accessory is not found"
     *   },
     *   section = "Quote Accessories section"
     * )
     *
     * @Annotations\View(templateVar="accessory", serializerEnableMaxDepthChecks=true)
     *
     * @param  int $project_id
     * @param  int $quote_id
     * @param  int $accessory_id
     * @return array
     */
    public function getAccessoryAction($project_id, $quote_id, $accessory_id) // "get_projects_quote_accessory" [GET] /api/projects/{project_id}/quotes/{quote_id}/accessories/{accessory_id}
    {
        $em = $this->getDoctrine()->getManager();

        if (!($project = $em->getRepository('AppBundle:Project')->find($project_id))) {
            throw new NotFoundHttpException('Project not found');
        }

        if (!($quote = $em->getRepository('AppBundle:Quote')->find($quote_id))) {
            throw new NotFoundHttpException('Quote not found');
        }

        if (!($accessory = $em->getRepository('AppBundle:Accessory')->find($accessory_id))) {
            throw new NotFoundHttpException('Accessory not found');
        }

        return ['accessory' => $accessory];
    }

    /**
     * Create a new Accessory
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\AccessoryType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Quote Accessories section"
     * )
     *
     * @Annotations\View(
     *   template = "AppBundle:Project:new.html.twig",
     *   statusCode = Response::HTTP_BAD_REQUEST
     * )
     *
     * @param  Request $request
     * @param  int $project_id
     * @param  int $quote_id
     * @return array|\FOS\RestBundle\View\View
     */
    public function postAccessoryAction(Request $request, $project_id, $quote_id) // "post_projects_quote_accessory" [POST] /api/projects/{project_id}/quotes/{quote_id}/accessories
    {
        $em = $this->getDoctrine()->getManager();

        if (!($project = $em->getRepository('AppBundle:Project')->find($project_id))) {
            throw new NotFoundHttpException('Project not found');
        }

        if (!($quote = $em->getRepository('AppBundle:Quote')->find($quote_id))) {
            throw new NotFoundHttpException('Quote not found');
        }

        $accessory = new Accessory();
        $accessory->setQuote($quote);

        $form = $this->createForm(new AccessoryType(), $accessory);

        $form->submit($request);

        if ($form->isValid()) {
            $em->persist($accessory);
            $em->flush();

            return $this->routeRedirectView(
                'get_projects_quote_accessory',
                [
                    'project_id'   => $project_id,
                    'quote_id'     => $quote_id,
                    'accessory_id' => $accessory->getId(),
                ]
            );
        }

        return ['form' => $form];
    }

    /**
     * Update a Accessory
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\AccessoryType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Quote Accessories section"
     * )
     *
     * @param  Request $request
     * @param  int     $project_id
     * @param  int     $quote_id
     * @param  int     $accessory_id
     * @return array|\FOS\RestBundle\View\View
     */
    public function putAccessoryAction(Request $request, $project_id, $quote_id, $accessory_id) // "put_projects_quote_accessory" [PUT] /api/projects/{project_id}/quotes/{quote_id}/accessories/{accessory_id}
    {
        $em = $this->getDoctrine()->getManager();

        if (!($project = $em->getRepository('AppBundle:Project')->find($project_id))) {
            throw new NotFoundHttpException('Project not found');
        }

        if (!($quote = $em->getRepository('AppBundle:Quote')->find($quote_id))) {
            throw new NotFoundHttpException('Quote not found');
        }

        if (!($accessory = $em->getRepository('AppBundle:Accessory')->find($accessory_id))) {
            throw new NotFoundHttpException('Accessory not found');
        }

        $form = $this->createForm(new AccessoryType(), $accessory);

        $form->submit($request);

        if ($form->isValid()) {
            $em->flush();

            return $this->routeRedirectView(
                'get_projects_quote_accessory',
                [
                    'project_id' => $project_id,
                    'quote_id'   => $quote_id,
                    'accessory_id' => $accessory->getId(),
                ],
                Response::HTTP_NO_CONTENT
            );
        }

        return ['form' => $form];
    }

    /**
     * Delete Accessory
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   },
     *   section = "Quote Accessories section"
     * )
     *
     * @param  int $project_id
     * @param  int $quote_id
     * @param  int $accessory_id
     * @return Response
     */
    public function deleteAccessoryAction($project_id, $quote_id, $accessory_id) // "delete_projects_quote_accessory" [DELETE] /api/projects/{project_id}/quotes/{quote_id}/accessories/{accessory_id}
    {
        $em = $this->getDoctrine()->getManager();

        if (($accessory = $em->getRepository('AppBundle:Accessory')->find($accessory_id))) {
            $em->remove($accessory);
            $em->flush();
        }

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * Re-order Accessories
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   },
     *   section = "Quote Accessories section"
     * )
     *
     * @param  Request $request
     * @param  int     $project_id
     * @param  int     $quote_id
     * @return Response
     */
    public function reorderAction(Request $request, $project_id, $quote_id)
    {
        $em = $this->getDoctrine()->getManager();

        if (!($project = $em->getRepository('AppBundle:Project')->find($project_id))) {
            throw new NotFoundHttpException('Project not found');
        }

        if (!($quote = $em->getRepository('AppBundle:Quote')->find($quote_id))) {
            throw new NotFoundHttpException('Quote not found');
        }

        if ($request->request->has('accessories')) {
            $stmt = $em->getConnection()->prepare("UPDATE accessories SET position = :position WHERE id = :accessoryId");

            foreach ($request->request->get('accessories') as $position => $accessoryId) {
                $stmt->execute([
                    ':position'    => $position,
                    ':accessoryId' => $accessoryId,
                ]);
            }
        }

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
