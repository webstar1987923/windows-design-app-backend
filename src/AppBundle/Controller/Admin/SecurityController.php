<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/admin/security")
 *
 */
class SecurityController extends Controller {
    /**
     * @Route("/token", name="admin_security_token")
     * @Method("GET")
     */
    public function generateToken()
    {
        $user = $this->getUser();
        // Call jwt_manager service & create the token
        $token = $this->get('lexik_jwt_authentication.jwt_manager')->create($user);

        // If you want, add some user informations
        $userInfo = [
            'id'         => $user->getId(),
            'username'   => $user->getUsername(),
            'email'      => $user->getEmail(),
            'roles'      => $user->getRoles(),
        ];

        // Build your response
        $response = array(
            'token' => $token,
            'user'  => $userInfo,
        );

        // Return the response in JSON format
        return new JsonResponse($response, 200);
    }
}
