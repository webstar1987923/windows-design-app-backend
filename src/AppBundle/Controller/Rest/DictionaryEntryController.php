<?php

namespace AppBundle\Controller\Rest;

use AppBundle\Entity\Dictionary;
use AppBundle\Entity\DictionaryEntry;
use AppBundle\Entity\DictionaryEntryProfile;
use AppBundle\Form\DictionaryEntryType;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Request\ParamFetcherInterface;
use AppBundle\Helpers\ParamFetcherHelper;

/**
 * Rest controller for Dictionary Entries
 *
 * @package AppBundle\Controller
 */
class DictionaryEntryController extends FOSRestController
{


    /**
     * List all dictionary entries
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
     * @Annotations\View(serializerGroups={"dictionary-entry-list"})
     *
     * @param Request $request the request object
     * @param int $dictionary_id the id of dictionary
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getEntriesAction(Request $request, $dictionary_id, ParamFetcherInterface $paramFetcher) // "get_dictionary_entries" [GET] /api/dictionaries/{dictionary_id}/entries
    {
        list($limit, $offset) = ParamFetcherHelper::getLimitAndOffset($paramFetcher);
        $limit = $limit ?: 0;

        $items = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:DictionaryEntry')->getDictionaryEntriesWithProfiles($dictionary_id, $offset, $limit);

        return [
            "entries" => $items,
            "offset" => $offset,
            "limit" => $limit
        ];
    }

    /**
     * @param Request $request
     * @param integer $dictionary_id
     * @param integer $entry_id
     * @return array
     */

    /**
     * Get a single dictionary entry
     *
     * @ApiDoc(
     *   output = "AppBundle\Entity\DictionaryEntry",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the unit is not found"
     *   },
     *   section = "Dictionary section"
     * )
     *
     * @Annotations\View()
     *
     * @param Request $request the request object
     * @param int $dictionary_id the project id
     * @param int $entry_id the unit_id
     *
     * @return array
     *
     * @throws NotFoundHttpException when project not exist
     * @throws NotFoundHttpException when unit not exist
     */
    public function getEntryAction(Request $request, $dictionary_id, $entry_id)
    {
        $dictionary = $this->getDoctrine()->getManager()->find("AppBundle:Dictionary", $dictionary_id);
        $repo = $this->getDoctrine()->getManager()->getRepository("AppBundle:DictionaryEntry");
        $entry = $repo->findOneBy([
            "id" => $entry_id,
            "dictionary" => $dictionary
        ]);

        if (empty($entry)) {
            return $this->createNotFoundException();
        }

        return ['dictionary_entry' => $entry];
    }

    /**
     * Creates a new dictionary entry from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\DictionaryEntryType",
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
     * @param int $dictionary_id the id of dictionary
     *
     * @return FormTypeInterface[]|View
     */
    public function postEntriesAction(Request $request, $dictionary_id) // post_dictionary_entries [POST] /api/dictionaries/{dictionary_id}/entries
    {
        /* @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $dictionary = $em->find("AppBundle:Dictionary", $dictionary_id);

        $entry = new DictionaryEntry();
        $entry->setDictionary($dictionary);
        $entryType = new DictionaryEntryType();

        $requestParams = $request->request->get($entryType->getName());

        $request->request->set($entryType->getName(), $requestParams);

        $form = $this->createForm($entryType, $entry);
        $form->submit($request);
        if ($form->isValid()) {
            $em->persist($entry);

            if (!empty($entryProfileData = $form['dictionary_entry_profiles']->all())) {
                $entryProfiles = array_map(function($epd){
                    return $epd->getData();
                }, $entryProfileData);
                $this->saveEntryProfiles($entryProfiles, $entry);
            }

            $em->flush();

            return $this->routeRedirectView('get_dictionary_entry',
                    array(
                        'dictionary_id' => $dictionary_id,
                        'entry_id' => $entry->getId()
                    ), Response::HTTP_CREATED);
        }

        return $form;

    }

    /**
     * Update existing entry from the submitted data or create a new at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\DictionaryEntryType",
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
     * @param int $entry_id the accessory id
     *
     * @return FormTypeInterface|RouteRedirectView
     *
     * @throws NotFoundHttpException when dictionary not exist
     */
    public function putEntryAction(Request $request, $dictionary_id, $entry_id) // "put_dictionary_entry"      [PUT] /api/dictionaries/{dictionary_id}/entries/{entry_id}
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $dictionary = $em->find("AppBundle:Dictionary", $dictionary_id);
        $entry = $this->getDoctrine()->getRepository('AppBundle:DictionaryEntry')->findOneBy(["dictionary" => $dictionary, "id" => $entry_id]);

        if (!$entry instanceof DictionaryEntry) {
            $entry = new DictionaryEntry();
            $entry->setId($entry_id);
            $entry->setDictionary($dictionary);
            $statusCode = Response::HTTP_CREATED;
        } else {
            $statusCode = Response::HTTP_NO_CONTENT;
        }

        $entryType = new DictionaryEntryType();
        $requestParams = $request->request->get($entryType->getName());

        $request->request->set($entryType->getName(), $requestParams);

        $form = $this->createForm($entryType, $entry);
        $form->submit($request);
        if ($form->isValid()) {
            $em->persist($entry);

            $entryProfiles = [];
            if (!empty($entryProfileData = $form['dictionary_entry_profiles']->all())) {
                $entryProfiles = array_map(function($epd){
                    return $epd->getData();
                }, $entryProfileData);
            }

            $this->saveEntryProfiles($entryProfiles, $entry);

            $em->flush();

            return $this->routeRedirectView('get_dictionary_entry', array('dictionary_id' => $dictionary_id, 'entry_id' => $entry->getId()), $statusCode);
        }
        return $form;
    }


    /**
     * Removes a dictionary entry.
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
     * @param int $dictionary_id the project id
     * @param int $entry_id the unit id
     *
     * @return View
     *
     * @throws NotFoundHttpException when project not exist
     */
    public function deleteEntryAction(Request $request, $dictionary_id, $entry_id) // "delete_dictionary_entry"   [DELETE] /api/dictionaries/{dictionary_id}/entries/{entry_id}
    {
        $item = $this->getDoctrine()->getRepository('AppBundle:DictionaryEntry')->find($entry_id);

        if ($item instanceof DictionaryEntry) {
            $em = $this->getDoctrine()->getManager();
            $this->deleteEntryProfiles($item);
            $em->remove($item);
            $em->flush();
        }
        return $this->routeRedirectView('get_dictionary_entries', array('dictionary_id' => $dictionary_id), Response::HTTP_NO_CONTENT);
    }

    /**
     * @param DictionaryEntryProfile[] $entryProfiles
     * @param DictionaryEntry $entry
     */
    private function saveEntryProfiles(array $entryProfiles, DictionaryEntry $entry)
    {
        $this->deleteEntryProfiles($entry);

        if (empty($entryProfiles)) {
            return;
        }

         // create new links
        foreach ($entryProfiles as $entryProfile) {
            $profile = $this->getDoctrine()->getManager()->getReference('AppBundle:Profile', $entryProfile->getProfileId());
            $entryProfile->setEntry($entry);
            $entryProfile->setProfile($profile);
            $this->getDoctrine()->getManager()->persist($entryProfile);
        }
    }

    /**
     * @param DictionaryEntry $entry
     */
    private function deleteEntryProfiles(DictionaryEntry $entry)
    {
        $this
            ->getDoctrine()
            ->getManager()
            ->createQuery('delete from AppBundle:DictionaryEntryProfile as dep where dep.entry = :entry')
            ->setParameter('entry', $entry)
            ->execute();
    }

    /**
     * Set entries order
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
     * @param int $dictionary_id
     *
     * @throws NotFoundHttpException when dictionary not exist
     *
     * @return View
     */
    public function reorderAction(Request $request, $dictionary_id) {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /* @var $dictionary Dictionary */
        $dictionary = $em->find("AppBundle:Dictionary", $dictionary_id);

        // Update the order of entries
        /* @var $stmt \Doctrine\DBAL\Driver\Statement */
        $stmt = $em->getConnection()->prepare('UPDATE dictionary_entry SET position = :number WHERE id = :id');
        $items = $request->request->get("entries", []);
        foreach ($items as $number => $itemID) {
            $stmt->execute([
                ":number" => $number,
                ":id" => $itemID
            ]);
        }

        return $this->routeRedirectView('get_dictionary_entries', array('dictionary_id' => $dictionary_id), Response::HTTP_NO_CONTENT);
    }
}
