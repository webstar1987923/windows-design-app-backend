<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\BinaryFile;
use AppBundle\Entity\Project;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/projects/{project_id}/files")
 *
 */
class ProjectFileController extends Controller
{
    /**
     * @Route("/", name="admin_project_files")
     * @Method("GET")
     * @Template("Admin/Project/File/index.html.twig")
     * @param $project_id
     * @return array
     */
    public function indexAction($project_id)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Project $parentEntity */
        $parentEntity = $em->getRepository('AppBundle:Project')->find($project_id);

        $entities = $parentEntity->getBinaryFiles();

        return [
            'parent_entity' => $parentEntity,
            'entities' => $entities,
        ];
    }

    /**
     * @Route("/create", name="admin_project_files_create")
     * @Method("GET")
     * @Template("Admin/Project/File/create.html.twig")
     * @param $project_id
     * @return array
     */
    public function createAction($project_id)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Project $parentEntity */
        $parentEntity = $em->getRepository('AppBundle:Project')->find($project_id);

        return [
            'parent_entity' => $parentEntity
        ];
    }

    /**
     * @Route("/{uuid}/delete", name="admin_project_files_delete")
     * @Method({"GET"})
     * @param $project_id
     * @param string $uuid The File uuid
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($project_id, $uuid)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var Project $parentEntity */
        $parentEntity = $em->getRepository('AppBundle:Project')->find($project_id);
        if (!$parentEntity instanceof Project) {
            $this->addFlash('alert alert-danger', 'Error: Project not found');
            return $this->redirectToRoute('admin_project_files', ['project_id' => $project_id]);
        }

        $entity = $em->getRepository('AppBundle:BinaryFile')->findOneBy(['uuid' => $uuid]);
        if (!$entity instanceof BinaryFile) {
            $this->addFlash('alert alert-warning', 'Warning: File not found');
        } else {
            $parentEntity->removeBinaryFile($entity);
            $em->flush($parentEntity);
            $this->addFlash('alert alert-success', 'File was removed from project');
        }

        return $this->redirectToRoute('admin_project_files', ['project_id' => $project_id]);
    }
}
