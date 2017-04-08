<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Form\ProjectType;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Project;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;

/**
 * @Route("/admin/users")
 *
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="admin_users")
     * @Method("GET")
     * @Template("Admin/User/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:User')->findBy(array(), array('id' => 'asc'));

        return [
            'entities' => $entities,
        ];
    }

    /**
     * @Route("/create", name="admin_users_create")
     * @Method("GET")
     * @Template("Admin/User/create.html.twig")
     * @return array Variables for template
     */
    public function createAction()
    {
        $entity = new User();
        $form = $this->buildCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );

    }

    /**
     * Creates a new User entity.
     *
     * @Route("/create", name="admin_users_create_handler")
     * @Method("POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createHandlerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new UserType(), $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $encoder = $this->container->get('security.password_encoder');

            $user->setLocked(false);
            $user->setEnabled(true);
            $user->setUsernameCanonical(strtolower($user->getUsername()));
            $user->setPassword($encoder->encodePassword($user, $user->getPassword())); //get plain password from the form field and encode it

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('alert alert-success', 'User was successfully created');
            return $this->redirectToRoute('admin_users');
        }

        return $this->render('Admin/User/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/delete", name="admin_users_delete")
     * @Method("POST")
     * @param int $id the User.id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:User')->findOneBy(['id' => $id]);

        if (!$entity) {
            $this->addFlash('alert alert-warning', 'Warning: User not found');
        } else {
            $em->remove($entity);
            $em->flush();
        }

        $this->addFlash('alert alert-success', 'User was successfully deleted');

        return $this->redirectToRoute('admin_users');
    }

    /**
     * Displays a form to update an existing User entity.
     *
     * @Route("/{id}/update", name="admin_users_update")
     * @Method("GET")
     * @Template("Admin/User/update.html.twig")
     * @param $id User id
     * @return array Variables for template
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User.');
        }

        $editForm = $this->buildUpdateForm($entity);

        return [
            'entity' => $entity,
            'edit_form' => $editForm->createView()
        ];
    }

    /**
     * Updates a User entity.
     *
     * @Route("/{id}/update", name="admin_users_update_handler")
     * @Method("PUT")
     * @param $id User id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateHandlerAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User.');
        }

        $entity->setPasswordConfirm($entity->getPassword()); // to prevent 'passwords doesn't match' error

        $editForm = $this->buildUpdateForm($entity);
        $editForm->handleRequest($request);


        if ($editForm->isValid()) {
            $entity->setUsernameCanonical(strtolower($entity->getUsername())); //update canonical username (using for login)
            $em->flush();
            $this->addFlash('alert alert-success', 'User was successfully updated');
            return $this->redirect($this->generateUrl('admin_users'));
        }

        return $this->render('Admin/User/update.html.twig', array(
            'edit_form' => $editForm->createView(),
            'entity' => $entity,
        ));
    }

    /**
     * @Route("/{id}/togglelock", name="admin_users_toggle_lock")
     * @Method("POST")
     * @param int $id the User.id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function toggleLockAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User.');
        }

        $entity->setLocked(!$entity->getLocked());
        $em->flush();
        $action = $entity->getLocked() ? 'banned' : 'unbanned';
        $this->addFlash('alert alert-success', 'User was successfully ' . $action);

        return $this->redirect($this->generateUrl('admin_users'));
    }

    /**
     * @Route("/{id}/toggleenable", name="admin_users_toggle_enable")
     * @Method("POST")
     * @param int $id the User.id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function toggleEnableAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User.');
        }

        $entity->setEnabled(!$entity->getEnabled());
        $em->flush();
        $action = $entity->getEnabled() ? 'enabled' : 'disabled';
        $this->addFlash('alert alert-success', 'User was successfully ' . $action);

        return $this->redirect($this->generateUrl('admin_users'));
    }

    /**
     * @Route("/{id}/change_password", name="admin_users_change_password")
     * @Method("GET")
     * @Template("Admin/User/update_password.html.twig")
     * @param int $id the User.id
     * @return array Variables for template
     */
    public function changePasswordAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:User')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User.');
        }
        $editForm = $this->changePasswordForm($entity);

        return [
            'entity' => $entity,
            'edit_form' => $editForm->createView()
        ];
    }


    /**
     * Displays a form to update an existing User entity.
     *
     * @Route("/{id}/change_password", name="admin_users_change_password_handler")
     * @Method("PUT")
     * @param $id User id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function changePasswordHandlerAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User.');
        }

        $editForm = $this->changePasswordForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $encoder = $this->container->get('security.password_encoder');
            $entity->setPassword($encoder->encodePassword($entity, $entity->getPassword())); //get plain password from the form field and encode it
            $em->flush();
            $this->addFlash('alert alert-success', 'User password was successfully updated');

            return $this->redirect($this->generateUrl('admin_users'));
        }

        return $this->render('Admin/User/update_password.html.twig', array(
            'edit_form' => $editForm->createView(),
            'entity' => $entity
        ));
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function buildCreateForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, [
            'action' => $this->generateUrl('admin_users_create_handler'),
            'method' => 'POST',
        ]);

        return $form;
    }

    /**
     * Creates a form to edit a User entity.
     *
     * @param User $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function buildUpdateForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, [
            'action' => $this->generateUrl('admin_users_update_handler', ['id' => $entity->getId()]),
            'method' => 'PUT',
        ]);
        $form->remove('password');
        $form->remove('passwordConfirm');

        return $form;
    }

    /**
     * Creates a form to edit a User entity.
     *
     * @param User $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function changePasswordForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, [
            'action' => $this->generateUrl('admin_users_change_password_handler', ['id' => $entity->getId()]),
            'method' => 'PUT',
        ]);
        $form->remove('username');
        $form->remove('email');
        $form->remove('firstname');
        $form->remove('lastname');
        $form->remove('roles');

        return $form;
    }

}
