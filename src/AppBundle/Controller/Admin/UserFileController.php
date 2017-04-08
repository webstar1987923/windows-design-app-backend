<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/admin/users/{user_id}/files")
 */
class UserFileController extends Controller
{
    /**
     * @Route("/", name="admin_user_files")
     * @Method("GET")
     * @Template("Admin/User/File/index.html.twig")
     * @param $user_id
     * @return array
     */
    public function indexAction($user_id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var User $user */
        $user = $em->getRepository('AppBundle:User')->find($user_id);
        $entities = $user->getBinaryFiles();
        return [
            'user' => $user,
            'entities' => $entities,
        ];
    }

}
