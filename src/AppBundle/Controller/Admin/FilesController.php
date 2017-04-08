<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\BinaryFile;
use AppBundle\Entity\Project;
use AppBundle\Entity\User;
use AppBundle\Manager\FilesManager;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Manage actions with Files
 *
 * @Route("/admin/files")
 */
class FilesController extends Controller
{
    /**
     * @Route("/", name="admin_files")
     * @Method("GET")
     * @Template("Admin/Files/index.html.twig")
     */
    public function indexAction()
    {
        /** @var FilesManager $fm */
        $fm = $this->container->get('app.manager.files');
        $tempEntities = $fm->getAllFilesFromTemp();
        $entities = $this->getDoctrine()->getManager()->getRepository('AppBundle:BinaryFile')->findBy([], array('updatedAt' => 'DESC'));

        $projectsInfo = array(); //will be used for tooltips in template
        foreach ($entities as $entity) {
            $current = $entity->getProject();
            if ($current) {
                $projectsInfo[] = array(
                    'id' => $current->getId(),
                    'project_name' => $current->getProjectName() ?: '-',
                    'project_address' => $current->getProjectAddress() ?: '-',
                    'quote_date' => $current->getQuoteDate() ?: '-',
                    'quote_revision' => $current->getQuoteRevision() ?: '-',
                    'client_name' => $current->getClientName() ?: '-',
                    'client_company_name' => $current->getClientCompanyName() ?: '-',
                    'client_phone' => $current->getClientPhone() ?: '-',
                    'client_address' => $current->getClientAddress() ?: '-',
                    'client_email' => $current->getClientEmail() ?: '-',
                    'project_files' => $current->getBinaryFiles() ? $current->getBinaryFiles()->count() : '0'
                );
            } else {
                $projectsInfo[] = null;
            }
        }

        $projects = $this->getDoctrine()->getManager()->getRepository('AppBundle:Project')->findAll();

        return [
            'entities' => $entities,
            'temp_entities' => $tempEntities,
            'projectsInfo' => $projectsInfo,
            'projects' => $projects,
        ];
    }

    /**
     * @Route("/{uuid}/delete", name="admin_files_delete")
     * @Method({"GET","POST"})
     * @param string $uuid The File uuid
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($uuid)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:BinaryFile')->findOneBy(['uuid' => $uuid]);
        if (!$entity) {
            $this->addFlash('alert alert-warning', 'Warning: File not found');
        } else {
            $fm = $this->get('app.manager.files');
            $dependencies = $fm->getFileDependencies($entity);

            foreach ($dependencies as $depGroupKey => $depGroupValue) {
                switch ($depGroupKey) {
                    case "users":
                        /** @var User $user */
                        foreach ($depGroupValue as $user) {
                            $user->removeBinaryFile($entity);
                        }
                        break;
                    case "projects":
                        /** @var Project $project */
                        foreach ($depGroupValue as $project) {
                            $project->removeBinaryFile($entity);
                        }
                        break;
                }
            }

            try {
                $binaryDataKey = $entity->getFilesystemName();
                $em->remove($entity);
                $em->flush();
                $fm->deleteLocalFileBinaryData($binaryDataKey);
            } catch (DBALException $e) {
                $this->addFlash('alert alert-danger', 'errors.item_in_use');
            }
        }

        return $this->redirectToRoute('admin_files');
    }

    /**
     * @Route("/link_user_files/{user_id}", name="admin_files_link_to_user")
     * @param Request $request
     * @param $user_id
     * @return array
     */
    public function linkFilesToUserAction(Request $request, $user_id)
    {
        /** @var FilesManager $fm */
        $fm = $this->container->get('app.manager.files');
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var EntityRepository $userRepo */
        $userRepo = $em->getRepository('AppBundle:User');
        /** @var User $user */
        $user = $userRepo->find($user_id);

        if (!$user instanceof User) throw new NotFoundHttpException('User with id: ' . $user_id . ' was not found');

        $files = $request->request->all();

        foreach ($files as $fileUuid) {
            $fm->linkTempFileToUser($fileUuid, $user);
        }

        $response = new Response(json_encode(['files' => $files, 'user' => $user]));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        //return ['files' => $files, 'user' => $user];
    }


    /**
     * @Route("/link_project_files/{project_id}", name="admin_files_link_to_project")
     * @param Request $request
     * @param $project_id
     * @return array
     */
    public function linkFilesToProjectAction(Request $request, $project_id)
    {
        /** @var FilesManager $fm */
        $fm = $this->container->get('app.manager.files');
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var Project $project */
        $project = $em->getRepository('AppBundle:Project')->find($project_id);
        $files = $request->request->all();

        foreach ($files as $fileUuid) {
            $fm->linkTempFileToProject($fileUuid, $project);
        }

        $response = new Response(json_encode(['files' => $files, 'project' => $project]));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        //return ['files' => $files, 'project' => $project];
    }

    /**
     * Clear temporary directory.
     *
     * @Route("/temp/clear", name="admin_files_clear_temp")
     * @Method("GET")
     * @param int $keep_age File age in seconds to keep in temp dir (skip remove)
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function clearTempAction($keep_age = 600)
    {
        /** @var FilesManager $fm */
        $fm = $this->container->get('app.manager.files');
        $fm->clearTempDirectory($keep_age);

        return $this->redirect($this->generateUrl('admin_files'));
    }

    /**
     * Delete temporary file and metadata.
     *
     * @Route("/temp/{uuid}/delete", name="admin_files_delete_temp")
     * @Method("GET")
     * @param string $uuid File uuid
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteTempFile($uuid)
    {
        /** @var FilesManager $fm */
        $fm = $this->container->get('app.manager.files');
        $fileContent = $uuid . FilesManager::BINARY_EXTENSION;
        $fileMetadata = $uuid . FilesManager::METADATA_EXTENSION;
        $fm->deleteTempFileBinaryData($fileContent);
        $fm->deleteTempFileBinaryData($fileMetadata);
        return $this->redirect($this->generateUrl('admin_files'));
    }

    /**
     * Displays a form to create a new UserFile entity.
     *
     * @Route("/create", name="admin_files_create")
     * @Method("GET")
     * @Template("Admin/Files/create.html.twig")
     */
    public function createAction()
    {
        $form = $this->createFormBuilder()
            ->add('save', 'submit', ['label' => 'Add file'])
            ->getForm();

        return [
            'form' => $form->createView(),
        ];
    }
}
