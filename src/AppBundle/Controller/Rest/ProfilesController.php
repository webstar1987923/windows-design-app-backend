<?php

namespace AppBundle\Controller\Rest;

use AppBundle\Entity\DictionaryEntryProfile;
use AppBundle\Entity\Profile;
use AppBundle\Form\ProfileType;
use AppBundle\Model\ProfileCollection;
use FOS\RestBundle\View\RouteRedirectView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;

/**
 * Rest controller for profiles
 *
 * @package AppBundle\Controller
 */
class ProfilesController extends FOSRestController
{
    /**
     * List all profiles
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   },
     *   section = "Profiles section"
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing profiles.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="0", description="How many profiles to return.")
     *
     * @Annotations\View(serializerGroups={"profile-list"})
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getProfilesAction(Request $request, ParamFetcherInterface $paramFetcher) // "get_profiles" [GET] /api/profiles
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        $limit = 0 == $limit ? null : $limit; // when 0 - then  unlimited
        $profiles = $this->getDoctrine()->getManager()->getRepository('AppBundle:Profile')->findBy([], ['position' => 'ASC'], $limit, $offset);
        return new ProfileCollection($profiles, $offset, $limit);
    }

    /**
     * Get a single profile.
     *
     * @ApiDoc(
     *   output = "AppBundle\Entity\Profile",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the profile is not found"
     *   },
     *   section = "Profiles section"
     * )
     *
     * @Annotations\View(templateVar="profiles")
     *
     * @param Request $request the request object
     * @param int     $profile_id      the profile id
     *
     * @return array
     *
     * @throws NotFoundHttpException when profile not exist
     */
    public function getProfileAction(Request $request, $profile_id) // "get_profile" [GET] /api/profiles/{profile_id}
    {
        $profile = $this->getDoctrine()->getRepository('AppBundle:Profile')->find($profile_id);
        if (!$profile instanceof Profile) {
            throw new NotFoundHttpException('Profile not found');
        }

        return ['profile' => $profile];
    }


    /**
     * Creates a new profile from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ProfileType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Profiles section"
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
    public function postProfilesAction(Request $request) // "post_profiles"     [POST] /api/profiles
    {
        $profile = new Profile();
        $form = $this->createForm(new ProfileType(), $profile);
        $form->submit($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($profile);
            $em->flush();
            return $this->routeRedirectView('get_profile', array('profile_id' => $profile->getId()));
        }
        return array(
            'form' => $form
        );
    }

    /**
     * Update existing profile from the submitted data or create a new profile at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ProfileType",
     *   statusCodes = {
     *     201 = "Returned when a new resource is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Profiles section"
     * )
     *
     * @Annotations\View(
     *   template="AppBundle:Project:edit.html.twig",
     *   templateVar="form"
     * )
     *
     * @param Request $request the request object
     * @param int     $profile_id      the profile id
     *
     * @return FormTypeInterface|RouteRedirectView
     *
     * @throws NotFoundHttpException when project not exist
     */
    public function putProfileAction(Request $request, $profile_id) // "put_profile"      [PUT] /api/profiles/{profile_id}
    {
        $profile = $this->getDoctrine()->getRepository('AppBundle:Profile')->find($profile_id);

        if (!$profile instanceof Profile) {
            $profile = new Profile();
            $profile->setId($profile_id);
            $statusCode = Response::HTTP_CREATED;
        } else {
            $statusCode = Response::HTTP_NO_CONTENT;
        }
        $form = $this->createForm(new ProfileType(), $profile);
        $form->submit($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($profile);
            $em->flush();
            return $this->routeRedirectView('get_profiles', array('id' => $profile->getId()), $statusCode);
        }
        return $form;
    }

    /**
     * Removes a profile.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   },
     *   section = "Profiles section"
     * )
     *
     * @param Request $request      the request object
     * @param int     $profile_id   the profile id
     *
     * @return View
     */
    public function deleteProfilesAction(Request $request, $profile_id) // "delete_profiles"   [DELETE] /api/profiles/{profile_id}
    {
        $profile = $this->getDoctrine()->getRepository('AppBundle:Profile')->find($profile_id);

        if ($profile instanceof Profile) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($profile);
            $em->flush();
        }
        // There is a debate if this should be a 404 or a 204
        // see http://leedavis81.github.io/is-a-http-delete-requests-idempotent/
        return $this->routeRedirectView('get_profiles', array(), Response::HTTP_NO_CONTENT);
    }

    /**
     * Removes a profile.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   },
     *   section = "Profiles section"
     * )
     *
     * @param Request $request      the request object
     * @param int     $profile_id   the profile id
     *
     * @return View
     */
    public function removeProfilesAction(Request $request, $profile_id) // "remove_profiles"   [GET] /api/profiles/{profile_id}/remove
    {
        return $this->deleteProfilesAction($request, $profile_id);
    }

    /**
     * Set profiles order
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   },
     *   section = "Profiles section"
     * )
     *
     * @param Request $request
     * @return View
     */
    public function reorderAction(Request $request) {

        // 2. Update the order of profiles
        /* @var $stmt \Doctrine\DBAL\Driver\Statement */
        $stmt = $this->getDoctrine()->getConnection()->prepare('UPDATE profiles SET position = :number WHERE id = :id');
        $units = $request->request->get("profiles", []);
        foreach ($units as $number => $unitID) {
            $stmt->execute([
                ":number" => $number,
                ":id" => $unitID
            ]);
        }

        return $this->routeRedirectView('get_profiles', [], Response::HTTP_NO_CONTENT);
    }
}
