<?php

namespace AppBundle\Controller\Rest;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Doctrine\ORM\EntityManager;

use FOS\RestBundle\View\RouteRedirectView;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;

use AppBundle\Entity\FillingType;
use AppBundle\Entity\FillingTypeProfile;
use AppBundle\Form\FillingTypeType;
use AppBundle\Model\FillingTypeCollection;

/**
 * Rest controller for profiles
 *
 * @package AppBundle\Controller
 */
class FillingTypesController extends FOSRestController
{
    /**
     * List all FillingTypes
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   },
     *   section = "FillingTypes section"
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", default=0, nullable=true, description="Offset from which to start listing resources.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default=0, description="How many resources to return.")
     *
     * @Annotations\View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return FillingTypeCollection
     */
    public function getFillingtypesAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder()
            ->select(['f', 'ftp', 'p'])
            ->from('AppBundle:FillingType', 'f')
            ->leftJoin('f.fillingTypeProfiles', 'ftp')
            ->leftJoin('ftp.profile', 'p')
            ->orderBy('f.position', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($limit ?: null)
        ;

        $fillingTypes = $qb->getQuery()->getResult();

        return new FillingTypeCollection($fillingTypes, $offset, $limit);
    }

    /**
     * Get a single FillingType
     *
     * @ApiDoc(
     *   output = "AppBundle\Entity\FillingType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the fillingType is not found"
     *   },
     *   section = "FillingTypes section"
     * )
     *
     * @Annotations\View(templateVar="fillingType", serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request the request object
     * @param int     $filling_type_id      The FillingType id
     *
     * @return array
     *
     * @throws NotFoundHttpException when fillingType not exist
     */
    public function getFillingtypeAction(Request $request, $filling_type_id)
    {
        $fillingType = $this->getDoctrine()->getRepository('AppBundle:FillingType')->find($filling_type_id);
        if (!$fillingType instanceof FillingType) {
            throw new NotFoundHttpException('FillingType not found');
        }

        return ['filling_type' => $fillingType];
    }


    /**
     * Creates a new FillingType from the submitted data
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\FillingTypeType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "FillingTypes section"
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
    public function postFillingtypesAction(Request $request)
    {
        $fillingType = new FillingType();
        $form = $this->createForm(new FillingTypeType(), $fillingType);
        $form->submit($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fillingType);

            if (!empty($fillingTypeProfileData = $form['filling_type_profiles']->all())) {
                $profiles = array_map(function($ftp){
                    return $ftp->getData();
                }, $fillingTypeProfileData);
                $this->saveFillingTypeProfiles($profiles, $fillingType);
            }

            $em->flush();
            return $this->routeRedirectView('get_fillingtype', array('filling_type_id' => $fillingType->getId()));
        }
        return array(
            'form' => $form
        );
    }

    /**
     * Update existing FillingType from the submitted data or create a new FillingType at a specific location (id)
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\FillingTypeType",
     *   statusCodes = {
     *     201 = "Returned when a new resource is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "FillingTypes section"
     * )
     *
     * @Annotations\View(
     *   template="AppBundle:Project:edit.html.twig",
     *   templateVar="form"
     * )
     *
     * @param Request $request the request object
     * @param int     $filling_type_id      The FillingType id
     *
     * @return FormTypeInterface|RouteRedirectView
     *
     * @throws NotFoundHttpException when fillingType not exist
     */
    public function putFillingtypeAction(Request $request, $filling_type_id)
    {
        $fillingType = $this->getDoctrine()->getRepository('AppBundle:FillingType')->find($filling_type_id);

        if (!$fillingType instanceof FillingType) {
            $fillingType = new FillingType();
            $fillingType->setId($filling_type_id);
            $statusCode = Response::HTTP_CREATED;
        } else {
            $statusCode = Response::HTTP_NO_CONTENT;
        }
        $form = $this->createForm(new FillingTypeType(), $fillingType);
        $form->submit($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fillingType);

            $profiles = [];

            if (!empty($fillingTypeProfileData = $form['filling_type_profiles']->all())) {
                $profiles = array_map(function($ftp){
                    return $ftp->getData();
                }, $fillingTypeProfileData);
            }

            $this->saveFillingTypeProfiles($profiles, $fillingType);

            $em->flush();
            return $this->routeRedirectView('get_fillingtype', array('filling_type_id' => $fillingType->getId()), $statusCode);
        }
        return $form;
    }

    /**
     * Removes a FillingType
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   },
     *   section = "FillingTypes section"
     * )
     *
     * @param Request $request      the request object
     * @param int     $filling_type_id           The FillingType id
     *
     * @return View
     */
    public function deleteFillingtypesAction(Request $request, $filling_type_id)
    {
        $fillingType = $this->getDoctrine()->getRepository('AppBundle:FillingType')->find($filling_type_id);

        if ($fillingType instanceof FillingType) {
            $em = $this->getDoctrine()->getManager();
            $this->deleteFillingTypeProfiles($fillingType);
            $em->remove($fillingType);
            $em->flush();
        }
        // There is a debate if this should be a 404 or a 204
        // see http://leedavis81.github.io/is-a-http-delete-requests-idempotent/
        return $this->routeRedirectView('get_fillingtypes', array(), Response::HTTP_NO_CONTENT);
    }

    /**
     * Removes a FillingType
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   },
     *   section = "FillingTypes section"
     * )
     *
     * @param Request $request      The request object
     * @param int     $filling_type_id           The FillingType id
     *
     * @return View
     */
    public function removeFillingtypesAction(Request $request, $filling_type_id)
    {
        return $this->deleteFillingTypesAction($request, $filling_type_id);
    }

    /**
     * Set filling types order
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   },
     *   section = "FillingTypes section"
     * )
     *
     * @param Request $request
     * @return View
     */
    public function reorderAction(Request $request) {

        // 2. Update the order of filling types
        /* @var $stmt \Doctrine\DBAL\Driver\Statement */
        $stmt = $this->getDoctrine()->getConnection()->prepare('UPDATE filling_types SET position = :number WHERE id = :id');
        $units = $request->request->get("filling_types", []);
        foreach ($units as $number => $unitID) {
            $stmt->execute([
                ":number" => $number,
                ":id" => $unitID
            ]);
        }

        return $this->routeRedirectView('get_fillingtypes', [], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param FillingTypeProfile[] $fillingTypeProfiles
     * @param FillingType $fillingType
     */
    private function saveFillingTypeProfiles(array $fillingTypeProfiles, FillingType $fillingType)
    {
        $this->deleteFillingTypeProfiles($fillingType);

        if (empty($fillingTypeProfiles)) {
            return;
        }

        foreach ($fillingTypeProfiles as $fillingTypeProfile) {
            $profile = $this->getDoctrine()->getManager()
                ->getReference('AppBundle:Profile', $fillingTypeProfile->getProfileId());

            $fillingTypeProfile->setFillingType($fillingType);
            $fillingTypeProfile->setProfile($profile);
            $this->getDoctrine()->getManager()->persist($fillingTypeProfile);
        }
    }

    /**
     * @param FillingType $fillingType
     */
    private function deleteFillingTypeProfiles(FillingType $fillingType)
    {
        $this
            ->getDoctrine()
            ->getManager()
            ->createQuery('delete from AppBundle:FillingTypeProfile as ftp where ftp.fillingType = :fillingType')
            ->setParameter('fillingType', $fillingType)
            ->execute();
    }
}
