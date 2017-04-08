<?php

namespace AppBundle\Controller\Rest;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManager;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Request\ParamFetcherInterface;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\Unit;
use AppBundle\Form\UnitType;
use AppBundle\Form\UnitOptionType;
use AppBundle\Model\UnitCollection;

/**
 * Class ProjectQuotesUnitsController
 */
class ProjectQuotesUnitsController extends FOSRestController
{
    /**
     * List all units
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   },
     *   section = "Quote Units section"
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", default="0", nullable=true, description="Offset from which to start listing units.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="10", description="How many units to return.")
     *
     * @Annotations\View(serializerEnableMaxDepthChecks=true)
     *
     * @param  int $project_id
     * @param  int $quote_id
     * @return UnitCollection
     */
    public function getUnitsAction(ParamFetcherInterface $paramFetcher, $project_id, $quote_id) // "get_projects_quote_units" [GET] /api/projects/{project_id}/quotes/{quote_id}/units
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

        $units = $em->getRepository('AppBundle:Unit')->findBy(['quote' => $quote], ['position' => 'ASC'], $limit, $offset);
        return new UnitCollection($units, $offset, $limit);
    }

    /**
     * Get a single unit.
     *
     * @ApiDoc(
     *   output = "AppBundle\Entity\Unit",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the unit is not found"
     *   },
     *   section = "Quote Units section"
     * )
     *
     * @Annotations\View(templateVar="unit", serializerEnableMaxDepthChecks=true)
     *
     * @param  int $project_id
     * @param  int $quote_id
     * @param  int $unit_id
     * @return array
     */
    public function getUnitAction($project_id, $quote_id, $unit_id) // "get_projects_quote_unit" [GET] /api/projects/{project_id}/quotes/{quote_id}/units/{unit_id}
    {
        $em = $this->getDoctrine()->getManager();

        if (!($project = $em->getRepository('AppBundle:Project')->find($project_id))) {
            throw new NotFoundHttpException('Project not found');
        }

        if (!($quote = $em->getRepository('AppBundle:Quote')->find($quote_id))) {
            throw new NotFoundHttpException('Quote not found');
        }

        if (!($unit = $em->getRepository('AppBundle:Unit')->find($unit_id))) {
            throw new NotFoundHttpException('Unit not found');
        }

        return ['unit' => $unit];
    }

    /**
     * Create a new Unit
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\UnitType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Quote Units section"
     * )
     *
     * @Annotations\View(
     *   template = "AppBundle:Project:new.html.twig",
     *   statusCode = Response::HTTP_BAD_REQUEST
     * )
     *
     * @param  Request $request
     * @param  int     $project_id
     * @param  int     $quote_id
     * @return array|\FOS\RestBundle\View\View
     */
    public function postUnitsAction(Request $request, $project_id, $quote_id) // "post_projects_quote_unit" [POST] /api/projects/{project_id}/quotes/{quote_id}/units
    {
        $em = $this->getDoctrine()->getManager();

        if (!($project = $em->getRepository('AppBundle:Project')->find($project_id))) {
            throw new NotFoundHttpException('Project not found');
        }

        if (!($quote = $em->getRepository('AppBundle:Quote')->find($quote_id))) {
            throw new NotFoundHttpException('Quote not found');
        }

        $unit = new Unit();
        $unit->setQuote($quote);

        $form = $this->createForm(new UnitType($this->get('doctrine.orm.entity_manager')), $unit);

        $form->submit($request);

        if ($form->isValid()) {
            if ($unit->getProfileId()) {
                $profile = $this->getDoctrine()->getManager()->find("AppBundle:Profile", $unit->getProfileId());
                $unit->setProfile($profile);
            }

            $em->persist($unit);

            $this->saveUnitOptions($unit->getId(), $form->get('unit_options')->getData());

            $em->flush();

            return $this->routeRedirectView(
                'get_projects_quote_unit',
                [
                    'project_id' => $project_id,
                    'quote_id'   => $quote_id,
                    'unit_id'    => $unit->getId(),
                ]
            );
        }

        return ['form' => $form];
    }

    /**
     * Update a Unit
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\UnitType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Quote Units section"
     * )
     *
     * @param  Request $request
     * @param  int $project_id
     * @param  int $quote_id
     * @param  int $unit_id
     * @return array|\FOS\RestBundle\View\View
     */
    public function putUnitAction(Request $request, $project_id, $quote_id, $unit_id) // "put_projects_quote_unit" [PUT] /api/projects/{project_id}/quotes/{quote_id}/units/{unit_id}
    {
        $em = $this->getDoctrine()->getManager();

        if (!($project = $em->getRepository('AppBundle:Project')->find($project_id))) {
            throw new NotFoundHttpException('Project not found');
        }

        if (!($quote = $em->getRepository('AppBundle:Quote')->find($quote_id))) {
            throw new NotFoundHttpException('Quote not found');
        }

        if (!($unit = $em->getRepository('AppBundle:Unit')->find($unit_id))) {
            throw new NotFoundHttpException('Unit not found');
        }

        $form = $this->createForm(new UnitType($this->get('doctrine.orm.entity_manager')), $unit);

        $form->submit($request);

        if ($form->isValid()) {
            $this->saveUnitOptions($unit->getId(), $form->get('unit_options')->getData());

            $em->flush();

            return $this->routeRedirectView(
                'get_projects_quote_unit',
                [
                    'project_id' => $project_id,
                    'quote_id'   => $quote_id,
                    'unit_id'    => $unit->getId(),
                ],
                Response::HTTP_NO_CONTENT
            );
        }

        return ['form' => $form];
    }

    /**
     * Delete Unit
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   },
     *   section = "Quote Units section"
     * )
     *
     * @param  int $project_id
     * @param  int $quote_id
     * @param  int $unit_id
     * @return Response
     */
    public function deleteUnitAction($project_id, $quote_id, $unit_id) // "delete_projects_quote_unit" [DELETE] /api/projects/{project_id}/quotes/{quote_id}/units/{unit_id}
    {
        $em = $this->getDoctrine()->getManager();

        if (($unit = $em->getRepository('AppBundle:Unit')->find($unit_id))) {
            $em->remove($unit);
            $em->flush();
        }

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * Re-order units
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   },
     *   section = "Quote Units section"
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

        if ($request->request->has('units')) {
            $stmt = $em->getConnection()->prepare("UPDATE units SET position = :position WHERE id = :unitId");

            foreach ($request->request->get('units') as $position => $unitId) {
                $stmt->execute([
                    ':position' => $position,
                    ':unitId'   => $unitId,
                ]);
            }
        }

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * Create unit options for a unit
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\UnitOptionType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Quote Units section"
     * )
     *
     * @Annotations\View(
     *   template = "AppBundle:Project:new.html.twig",
     *   statusCode = Response::HTTP_BAD_REQUEST
     * )
     *
     * @param  Request $request
     * @param  int     $project_id
     * @param  int     $quote_id
     * @param  int     $unit_id
     * @return array
     */
    public function postUnitOptionsAction(Request $request, $project_id, $quote_id, $unit_id) // "post_projects_quote_units_options" [POST] /api/projects/{project_id}/quotes/{quote_id}/units/{unit_id}/options
    {
        $em = $this->getDoctrine()->getManager();

        if (!($project = $em->getRepository('AppBundle:Project')->find($project_id))) {
            throw new NotFoundHttpException('Project not found');
        }

        if (!($quote = $em->getRepository('AppBundle:Quote')->find($quote_id))) {
            throw new NotFoundHttpException('Quote not found');
        }

        if (!($unit = $em->getRepository('AppBundle:Unit')->find($unit_id))) {
            throw new NotFoundHttpException('Unit not found');
        }

        /** @var FormFactory $formFactory */
        $formFactory = $this->get('form.factory');
        $form = $formFactory->createNamedBuilder('', 'form', null, [
            'csrf_protection' => false,
        ])
            ->add('unit_options', 'collection', [
                'type' => new UnitOptionType($unit, $this->get('doctrine.orm.entity_manager')),
                'allow_add' => true,
            ])
            ->getForm()
        ;

        $form->submit($request);

        if ($form->isValid()) {
            $this->saveUnitOptions($unit->getId(), $form->get('unit_options')->getData());
            return new Response('', Response::HTTP_NO_CONTENT);
        }

        return ['form' => $form];
    }

    /**
     * @param int   $unitId
     * @param array $unitOptions
     */
    protected function saveUnitOptions($unitId, $unitOptions)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $stmt = $em->getConnection()->prepare("DELETE FROM unit_option WHERE unit_id = :unitId");
        $stmt->execute([':unitId' => $unitId]);

        if (!empty($unitOptions)) {
            foreach ($unitOptions as $unitOption) {
                $em->persist($unitOption);
            }
        }

        $em->flush();
    }
}
