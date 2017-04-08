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
use AppBundle\Helpers\UuidHelper;
use Gaufrette\Exception\FileNotFound;

/**
 * @Route("/admin/projects")
 *
 */
class ProjectController extends Controller
{
    /**
     * @Route("/", name="admin_projects")
     * @Method("GET")
     * @Template("Admin/Project/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Project')->findAll();

        return [
            'entities' => $entities,
        ];
    }

    /**
     * Displays a form to create a new Project entity.
     *
     * @Route("/create", name="admin_projects_create")
     * @Method("GET")
     * @Template("Admin/Project/create.html.twig")
     */
    public function createAction()
    {
        $entity = new Project();
        $form = $this->buildCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Project entity.
     *
     * @Route("/create", name="admin_projects_create_handler")
     * @Method("POST")
     * @Template("Admin/Project/create.html.twig")
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createHandlerAction(Request $request)
    {
        $entity = new Project();
        $form = $this->buildCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            if (!$entity->getProjectNotes()) {
                $entity->setProjectNotes('');
            }
            if (!$entity->getShippingNotes()) {
                $entity->setShippingNotes('');
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $preloadedFiles = $request->request->get('preloaded_files');
            if (is_array($preloadedFiles) && (count($preloadedFiles) > 0)) {
                $fm = $this->container->get('app.manager.files');
                foreach ($preloadedFiles as $fileUuid) {
                    $fm->linkTempFileToProject($fileUuid, $entity);
                    $file = $em->getRepository('AppBundle:BinaryFile')->find($fileUuid);
                    $fm->linkFileToUser($file, $this->getUser()); // Add to CurrentUser Files
                }
            }

            return $this->redirect($this->generateUrl('admin_projects'));
        }

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Displays a form to clone a Project entity.
     *
     * @Route("/{id}/clone", name="admin_projects_clone")
     * @Method("GET")
     * @param $id Project id
     * @Template("Admin/Project/clone.html.twig")
     * @return array
     */
    public function cloneAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project to clone.');
        }

        $clonedEntity = clone $entity;
        $form = $this->buildCloneForm($clonedEntity, $entity->getId());

        return array(
            'entity' => $clonedEntity,
            'clone_form' => $form->createView(),
        );
    }

    /**
     * Creates a form to clone Project entity.
     *
     * @param Project $entity The entity
     * @param int $parentId Id of the parent project
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function buildCloneForm(Project $entity, $parentId = null)
    {
        $form = $this->createForm(new ProjectType(), $entity, [
            'action' => $this->generateUrl('admin_projects_clone_handler'),
            'method' => 'POST',
            'allow_extra_fields' => true
        ]);

        if ($parentId) {
            // hidden field with parent project id
            $form->add('parentId', 'hidden', array(
                'data' => $parentId,
                'mapped' => false
            ));
        }
        $form->add('submit', 'submit', ['label' => 'Create']);

        return $form;
    }

    /**
     * Clones Project entity.
     *
     * @Route("/clone", name="admin_projects_clone_handler")
     * @Method("POST")
     * @Template("Admin/Project/clone.html.twig")
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function cloneHandlerAction(Request $request)
    {
        $localFS = $this->container->get('gaufrette.local_filesystem');
        $project = new Project();
        $form = $this->buildCloneForm($project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$project->getProjectNotes()) {
                $project->setProjectNotes('');
            }
            if (!$project->getShippingNotes()) {
                $project->setShippingNotes('');
            }
            //  Make sure unique fields aren't cloned
            $project->setFrontappThreadId(null);
            $project->setFrontappGdriveFolderId(null);
            $project->setDapulsePulseId(null);
            $project->setExtraIdData(null);

            $parentId = (int)$form->getExtraData()['parentId'];
            $em = $this->getDoctrine()->getManager();
            $parentProject = $em->getRepository('AppBundle:Project')->findOneBy(array('id' => $parentId));

            //  Recursively clone Project's Quotes
            $quotes = $parentProject->getQuotes();
            foreach ($quotes as $quote) {
                $clonedQuote = clone $quote;

                $units = $quote->getUnits();
                foreach ($units as $unit) {
                    $clonedUnit = clone $unit;

                    $unitOptions = $unit->getOptions();
                    foreach ($unitOptions as $option) {
                        $clonedOption = clone $option;
                        $clonedOption->setUnit($clonedUnit);
                        $clonedUnit->addOption($clonedOption);
                    }

                    $clonedQuote->addUnit($clonedUnit);
                    $clonedUnit->setQuote($clonedQuote);
                }

                $accessories = $quote->getAccessories();
                foreach ($accessories as $accessory) {
                    $clonedAccessory = clone $accessory;
                    $clonedQuote->addAccessory($clonedAccessory);
                    $clonedAccessory->setQuote($clonedQuote);
                }

                $project->addQuote($clonedQuote);
            }

            $binaryFiles = $parentProject->getBinaryFiles();
            foreach ($binaryFiles as $binaryFile) {
                $clonedBinaryFile = clone $binaryFile;
                $clonedBinaryFile->setUuid(UuidHelper::NewUuid());
                $clonedBinaryFile->setFilesystemName($clonedBinaryFile->getUuid() . '.bin');
                $clonedBinaryFile->setHasThumbnail(true);
                $clonedBinaryFile->updateAuditFields($this->getUser());
                //clone file
                if ($localFS->has($binaryFile->getUuid() . '.bin')) {
                    $content = $localFS->read($binaryFile->getUuid() . '.bin');
                    $localFS->write($clonedBinaryFile->getUuid() . '.bin', $content);
                } else throw new FileNotFound($binaryFile->getUuid() . '.bin');
                //clone thumbnail
                if ($localFS->has($binaryFile->getUuid() . '-thumbnail.bin')) {
                    $content = $localFS->read($binaryFile->getUuid() . '-thumbnail.bin');
                    $localFS->write($clonedBinaryFile->getUuid() . '-thumbnail.bin', $content);
                } else throw new FileNotFound($binaryFile->getUuid() . '-thumbnail.bin');
                $project->addBinaryFile($clonedBinaryFile);
            }

            $em->persist($project);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_projects'));
        }

        return [
            'entity' => $project,
            'clone_form' => $form->createView(),
        ];
    }

    /**
     * Creates a form to create a Project entity.
     *
     * @param Project $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function buildCreateForm(Project $entity)
    {
        $form = $this->createForm(new ProjectType(), $entity, [
            'action' => $this->generateUrl('admin_projects_create_handler'),
            'method' => 'POST',
        ]);

        // $form->add('submit', 'submit', ['label' => 'Create']);

        return $form;
    }

    /**
     * Displays a form to update an existing Project entity.
     *
     * @Route("/{id}/update", name="admin_projects_update")
     * @Method("GET")
     * @Template("Admin/Project/update.html.twig")
     * @param $id Project id
     * @return array
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project.');
        }

        $editForm = $this->buildUpdateForm($entity);

        return [
            'entity' => $entity,
            'edit_form' => $editForm->createView()
        ];
    }

    /**
     * Creates a form to edit a Project entity.
     *
     * @param Project $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function buildUpdateForm(Project $entity)
    {
        $form = $this->createForm(new ProjectType(), $entity, [
            'action' => $this->generateUrl('admin_projects_update_handler', ['id' => $entity->getId()]),
            'method' => 'PUT',
        ]);

        $form->add('submit', 'submit', ['label' => 'Update']);

        return $form;
    }

    /**
     * Edits an existing Project entity.
     *
     * @Route("/{id}/update", name="admin_projects_update_handler")
     * @Method("PUT")
     * @Template("Admin/Project/update.html.twig")
     * @param Request $request
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateHandlerAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project.');
        }

        $editForm = $this->buildUpdateForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            if (!$entity->getProjectNotes()) {
                $entity->setProjectNotes('');
            }
            if (!$entity->getShippingNotes()) {
                $entity->setShippingNotes('');
            }
            $em->flush();
            $this->addFlash('alert alert-success', 'Project updated successfully');
            return $this->redirect($this->generateUrl('admin_projects_update', ['id' => $id]));
        }

        return [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        ];
    }

    /**
     * @Route("/{id}/deleteconfirm", name="admin_projects_delete_confirm")
     * @Method("GET")
     * @Template("Admin/Project/delete-confirm.html.twig")
     *
     * @param int $id the Project.id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteConfirmAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Project')->findOneBy(['id' => $id]);
        if ($entity == null) {
            $this->addFlash('alert alert-danger', 'Warning: Project not found');
            return $this->redirectToRoute('admin_projects');
        }

        $this->addFlash('alert alert-warning', 'Warning: The project you want to delete will be deleted with all dependencies such as Units, Files, Accessories, etc.');

        return [
            'entity' => $entity,
        ];
    }

    /**
     * @Route("/{id}/delete", name="admin_projects_delete")
     * @Method("POST")
     * @Template("Admin/Project/index.html.twig")
     * @param int $id the Project.id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Project')->findOneBy(['id' => $id]);
        if (!$entity) {
            $this->addFlash('alert alert-warning', 'Warning: Project not found');
        } else {
            $em->remove($entity);
            try {
                $em->flush();
            } catch (DBALException $e) {
                $this->addFlash('alert alert-danger', 'errors.item_in_use');
            }
        }

        return $this->redirectToRoute('admin_projects');
    }
}