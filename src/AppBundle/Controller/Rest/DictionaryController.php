<?php

namespace AppBundle\Controller\Rest;

use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Doctrine\ORM\QueryBuilder;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Request\ParamFetcherInterface;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\Dictionary;
use AppBundle\Form\DictionaryType;
use AppBundle\Model\DictionaryCollection;
use AppBundle\Helpers\ParamFetcherHelper;

/**
 * Rest controller for dictionary
 *
 * @package AppBundle\Controller
 */
class DictionaryController extends FOSRestController
{
    /**
     * Creates a new dictionary from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\DictionaryType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Dictionary section"
     * )
     *
     * @Annotations\View(
     *   template = "AppBundle:Project:new.html.twig",
     *   statusCode = Response::HTTP_BAD_REQUEST
     * )
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface[]|View
     */
    public function postDictionariesAction(Request $request) // post_dictionaries [POST] /api/dictionaries
    {
        $dictionary = new Dictionary();
        $form = $this->createForm(new DictionaryType(), $dictionary);
        $form->submit($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dictionary);
            $em->flush();
            //return $this->routeRedirectView('get_dictionary', ['dictionary_id' => $dictionary->getId()]);
            return $this->redirectView('/api/dictionaries/' . $dictionary->getId(), Codes::HTTP_CREATED);
        }
        return array(
            'form' => $form
        );
    }

    /**
     * Update existing dictionary from the submitted data or create a new dictionary at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\DictionaryType",
     *   statusCodes = {
     *     201 = "Returned when a new resource is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Dictionary section"
     * )
     *
     * @Annotations\View(
     *   template="AppBundle:Project:edit.html.twig",
     *   templateVar="form"
     * )
     *
     * @param Request $request the request object
     * @param int $dictionary_id the dictionary id
     *
     * @return FormTypeInterface|RouteRedirectView
     *
     * @throws NotFoundHttpException when project not exist
     */
    public function putDictionaryAction(Request $request, $dictionary_id) // "put_dictionary"      [PUT] /api/dictionaries/{dictionary_id}
    {
        $dictionary = $this->getDoctrine()->getRepository('AppBundle:Dictionary')->find($dictionary_id);

        if (!$dictionary instanceof Dictionary) {
            $dictionary = new Dictionary();
            $dictionary->setId($dictionary_id);
            $statusCode = Response::HTTP_CREATED;
        } else {
            $statusCode = Response::HTTP_NO_CONTENT;
        }
        $form = $this->createForm(new DictionaryType(), $dictionary);
        $form->submit($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dictionary);
            $em->flush();
            return $this->routeRedirectView('get_dictionaries', array('id' => $dictionary->getId()), $statusCode);
        }
        return $form;
    }

    /**
     * List all dictionaries
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   },
     *   section = "Dictionary section"
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing items.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="0", description="How many items to return.")
     *
     * @Annotations\View(serializerGroups={"dictionary-list"})
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getDictionariesAction(Request $request, $offset = 0, $limit = 0) // "get_dictionaries" [GET] /api/dictionaries
    {
        $items = $this->getDoctrine()->getManager()->getRepository('AppBundle:Dictionary')->findBy([], ['position' => 'ASC'], $limit ? $limit : null, $offset);
        return new DictionaryCollection($items, $offset, $limit);
    }

    /**
     * List all dictionaries as full-tree
     *
     * @Route("api/dictionaries/full-tree", name="get_dictionaries_full")
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   },
     *   section = "Dictionary section"
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing items.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="0", description="How many items to return.")
     *
     * @Annotations\View(serializerGroups={"dictionary-list", "dictionary-entry-list"})
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getDictionariesFulltreeAction(Request $request, ParamFetcherInterface $paramFetcher) // "get_dictionaries_full" [GET] /api/dictionaries/full-tree
    {
        list($limit, $offset) = ParamFetcherHelper::getLimitAndOffset($paramFetcher);

        /** @var QueryBuilder $qb */
        $qb = $this->getDoctrine()->getManager()->createQueryBuilder();
        $qb
            ->select([
                'dictionary',
                'dictEntry',
                'dictEntryProfile',
                'profile',
            ])
            ->from('AppBundle:Dictionary', 'dictionary')
            ->leftJoin('dictionary.entries', 'dictEntry')
            ->leftJoin('dictEntry.dictionaryEntryProfiles', 'dictEntryProfile')
            ->leftJoin('dictEntryProfile.profile', 'profile')
            ->setFirstResult($offset ?: 0)
            ->setMaxResults($limit ?: null)
            ->orderBy('dictionary.name, dictEntry.position', 'ASC')
        ;

        $items = $qb->getQuery()->getResult();

        return [
            "dictionaries" => $items,
            "offset" => $offset,
            "limit" => $limit
        ];
    }

    /**
     * Get a single dictionary.
     *
     * @ApiDoc(
     *   output = "AppBundle\Entity\Dictionary",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the item is not found"
     *   },
     *   section = "Dictionary section"
     * )
     *
     * @Annotations\View(templateVar="dictionaries")
     *
     * @param Request $request the request object
     * @param int $dictionary_id
     *
     * @return array
     *
     * @throws NotFoundHttpException when dictionary not exist
     */
    public function getDictionaryAction(Request $request, $dictionary_id) // "get_dictionary" [GET] /api/dictionary/{dictionary_id}
    {
        if ($dictionary = $this->getDoctrine()->getRepository('AppBundle:Dictionary')->find($dictionary_id)) {
            return ['dictionary' => $dictionary];
        }

        throw new NotFoundHttpException('Dictionary not found');
    }

    /**
     * Removes a dictionary.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   },
     *   section = "Dictionary section"
     * )
     *
     * @param Request $request the request object
     * @param int $dictionary_id the dictionary id
     *
     * @return View
     */
    public function deleteDictionaryAction(Request $request, $dictionary_id) // "delete_dictionary"   [DELETE] /api/dictionaries/{dictionary_id}
    {
        $item = $this->getDoctrine()->getRepository('AppBundle:Dictionary')->find($dictionary_id);

        if ($item instanceof Dictionary) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($item);
            $em->flush();
        }
        return $this->routeRedirectView('get_dictionaries', array(), Response::HTTP_NO_CONTENT);
    }

    /**
     * Removes dictionary.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   },
     *   section = "Dictionary section"
     * )
     *
     * @param Request $request the request object
     * @param int $dictionary_id the dictionary id
     *
     * @return View
     */
    public function removeDictionaryAction(Request $request, $dictionary_id) // "remove_dictionary"   [GET] /api/dictionaries/{dictionary_id}/remove
    {
        return $this->deleteProfilesAction($request, $dictionary_id);
    }

    /**
     * Set dictionaries order
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   },
     *   section = "Dictionary section"
     * )
     *
     * @param Request $request
     * @return View
     */
    public function reorderAction(Request $request) {

        // Update the order of dictionaries
        /* @var $stmt \Doctrine\DBAL\Driver\Statement */
        $stmt = $this->getDoctrine()->getConnection()->prepare('UPDATE dictionary SET position = :number WHERE id = :id');
        $items = $request->request->get("dictionaries", []);
        foreach ($items as $number => $itemID) {
            $stmt->execute([
                ":number" => $number,
                ":id" => $itemID
            ]);
        }

        return $this->routeRedirectView('get_dictionaries', [], Response::HTTP_NO_CONTENT);
    }
}
