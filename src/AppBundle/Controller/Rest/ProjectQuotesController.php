<?php

namespace AppBundle\Controller\Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Request\ParamFetcherInterface;

use AppBundle\Entity\Quote;
use AppBundle\Form\QuoteType;
use AppBundle\Model\QuoteCollection;

/**
 * Class ProjectQuotesController
 */
class ProjectQuotesController extends FOSRestController
{
    /**
     * List all quotes
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   },
     *   section = "Quotes section"
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", default="0", description="Offset from which to start listing units.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="10", description="How many units to return.")
     *
     * @Annotations\View(serializerEnableMaxDepthChecks=true)
     *
     * @param  ParamFetcherInterface $paramFetcher
     * @param  int                   $project_id
     * @return QuoteCollection
     */
    public function getQuotesAction(ParamFetcherInterface $paramFetcher, $project_id) // "get_projects_quotes" [GET] /api/projects/{project_id}/quotes
    {
        $em = $this->getDoctrine()->getManager();

        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');

        if (!($project = $em->getRepository('AppBundle:Project')->find($project_id))) {
            throw new NotFoundHttpException('Project not found');
        }

        $quotes = $em->getRepository('AppBundle:Quote')->findBy([
            'project' => $project,
        ], ['position' => 'ASC'], $limit, $offset);

        return new QuoteCollection($quotes, $offset, $limit);
    }

    /**
     * List a single quote
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   },
     *   section = "Quotes section"
     * )
     *
     * @Annotations\View(templateVar="quote", serializerEnableMaxDepthChecks=true)
     *
     * @param  int $project_id
     * @param  int $quote_id
     * @return array
     */
    public function getQuoteAction($project_id, $quote_id) // "get_projects_quote" [GET] /api/projects/{project_id}/quotes/{quote_id}
    {
        $em = $this->getDoctrine()->getManager();

        $quote = $em->getRepository('AppBundle:Quote')->findOneBy([
            'id'      => $quote_id,
            'project' => $project_id,
        ]);

        if (!$quote) {
            throw new NotFoundHttpException('Quote not found');
        }

        return ['quote' => $quote];
    }

    /**
     * Create a new Quote
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\QuoteType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Quotes section"
     * )
     *
     * @param  Request $request
     * @param  int     $project_id
     * @return array|\FOS\RestBundle\View\View
     */
    public function postQuotesAction(Request $request, $project_id) // "post_projects_quote" [POST] /api/projects/{project_id}/quotes
    {
        $em = $this->getDoctrine()->getManager();

        if (!($project = $em->getRepository('AppBundle:Project')->findOneBy(['id' => $project_id]))) {
            throw new BadRequestHttpException('Invalid Project');
        }

        $quote = new Quote();
        $quote->setProject($project);

        $form = $this->createForm(new QuoteType(), $quote, array(
            'entity_manager' => $this->get('doctrine.orm.entity_manager')
        ));
        $form->submit($request);

        if ($form->isValid()) {
            // see if we already have a default Quote for this Project
            $hasDefault = $em->getRepository('AppBundle:Quote')->findOneBy([
                'project'    => $project,
                'is_default' => true,
            ]);

            //  If form contains units, attach them to the Quote
            foreach($form->get('units') as $unitEntry) {
                $unit = $unitEntry->getData();

                foreach($unitEntry['unit_options'] as $optionEntry) {
                    $option = $optionEntry->getData();
                    $unit->addOption($option);
                    $option->setUnit($unit);
                }

                if ($unit->getProfileId()) {
                    $profile = $this->getDoctrine()->getManager()->find("AppBundle:Profile", $unit->getProfileId());
                    $unit->setProfile($profile);
                }

                $quote->addUnit($unit);
                $unit->setQuote($quote);
            }

            //  If form contains accessories, also attach them to the Quote
            foreach($form->get('accessories')->getData() as $accessory) {
                $quote->addAccessory($accessory);
                $accessory->setQuote($quote);
            }

            if (!$hasDefault) {
                $quote->setIsDefault(true);
            }

            $em->persist($quote);
            $em->flush();

            return $this->routeRedirectView(
                'get_projects_quote',
                [
                    'project_id' => $project_id,
                    'quote_id'   => $quote->getId(),
                ]
            );
        }

        return ['form' => $form];
    }

    /**
     * Update a Quote
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\QuoteType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Quotes section"
     * )
     *
     * @param  Request $request
     * @param  int     $project_id
     * @param  int     $quote_id
     * @return array|\FOS\RestBundle\View\View
     */
    public function putQuoteAction(Request $request, $project_id, $quote_id) // "put_projects_quote" [PUT] /api/projects/{project_id}/quotes/{quote_id}
    {
        $em = $this->getDoctrine()->getManager();

        if (!($project = $em->getRepository('AppBundle:Project')->find($project_id))) {
            throw new NotFoundHttpException('Project not found');
        }

        if (!($quote = $em->getRepository('AppBundle:Quote')->find($quote_id))) {
            throw new NotFoundHttpException('Quote not found');
        }

        $form = $this->createForm(new QuoteType(), $quote, array(
            'entity_manager' => $this->get('doctrine.orm.entity_manager')
        ));
        $form->submit($request);

        if ($form->isValid()) {
            $em->flush();

            return $this->routeRedirectView(
                'get_projects_quote',
                [
                    'project_id' => $project_id,
                    'quote_id'   => $quote->getId(),
                ],
                Response::HTTP_NO_CONTENT
            );
        }

        return ['form' => $form];
    }

    /**
     * Delete Quote
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   },
     *   section = "Quotes section"
     * )
     *
     * @param  int $project_id
     * @param  int $quote_id
     * @return Response
     */
    public function deleteQuoteAction($project_id, $quote_id) // "delete_projects_quote" [DELETE] /api/projects/{project_id}/quotes/{quote_id}
    {
        $em = $this->getDoctrine()->getManager();

        if (!($project = $em->getRepository('AppBundle:Project')->find($project_id))) {
            throw new NotFoundHttpException('Project not found');
        }

        if (!($quote = $em->getRepository('AppBundle:Quote')->find($quote_id))) {
            throw new NotFoundHttpException('Quote not found');
        }

        $em->remove($quote);
        $em->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * Re-order Quotes
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   },
     *   section = "Quote section"
     * )
     *
     * @param  Request $request
     * @param  int     $project_id
     * @return Response
     */
    public function reorderAction(Request $request, $project_id)
    {
        $em = $this->getDoctrine()->getManager();

        if (!($project = $em->getRepository('AppBundle:Project')->find($project_id))) {
            throw new NotFoundHttpException('Project not found');
        }

        if ($request->request->has('quotes')) {
            $stmt = $em->getConnection()->prepare("UPDATE quotes SET position = :position WHERE id = :quoteId");
            foreach ($request->request->get('quotes') as $position => $quoteId) {
                $stmt->execute([
                    ':position'    => $position,
                    ':quoteId' => $quoteId,
                ]);
            }
        }

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
