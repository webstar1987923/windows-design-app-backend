<?php

namespace AppBundle\Controller\Rest;

use AppBundle\Entity\User;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\UserType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Rest controller for users
 */
class UsersController extends FOSRestController
{
    /**
     * Get a current user
     *
     * @ApiDoc(
     *   output = {
     *      "class" = "AppBundle\Entity\User",
     *      "groups" = {"api"}
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the user is not found"
     *   },
     *   section = "Users section",
     *   description = "Get current user info as User{id, username, email}"
     * )
     *
     * @return Response
     *
     * @throws NotFoundHttpException when user not exist
     */
    public function getUsersCurrentAction() // "get_users_current" [GET] /api/users/current
    {
        $token = $this->get('security.token_storage')->getToken();
        if (!$token) {
            throw new AccessDeniedHttpException('Wrong or empty token');
        }
        $user = $token->getUser();

        if (!$user instanceof User) {
            throw new NotFoundHttpException('Could not get User data');
        }

        $view = $this->view(["user" => $user], 200)->setSerializationContext(SerializationContext::create()->setGroups(['api']));
        return $this->handleView($view);
    }

    /**
     * Register a new user
     *
     * @Post("/register")
     *
     * @ApiDoc(
     *   output = {
     *      "class" = "AppBundle\Entity\User",
     *      "groups" = {"api"}
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when form data is invalid"
     *   },
     *   section = "Users section",
     *   description = "Register a new user"
     * )
     *
     * @return JsonResponse
     */
    public function postRegisterAction(Request $request) // "post_register" [POST] /api/register
    {
        $user = new User();
        $user->setRoles(array('ROLE_USER'));

        $form = $this->createForm(new UserType(), $user);
        $form->remove('roles');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $user->setLocked(false)->setEnabled(false)->setUsernameCanonical(strtolower($user->getUsername()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return new JsonResponse(array('status' => Response::HTTP_OK));
        }

        $form_errors = $this->get('form_errors')->getArray($form); // Form/FormErrors service

        return new JsonResponse((array('status' => Response::HTTP_BAD_REQUEST, 'errors' => $form_errors)));

    }
}