<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/admin/dashboard")
 *
 */
class DashboardController extends Controller
{
    /**
     * @Route("", name="admin_dashboard")
     * @Method("GET")
     * @Template("Admin/Dashboard/index.html.twig")
     */
    public function indexAction()
    {
        return [];
    }

    // Can be called as ajax
    public function dashboardProjectsAction($max = 5)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Project')->findAll();

        $vm = [];
        //$vm['entities'] = [];
        $vm['projects_count'] = count($entities);
        return $this->render(
            ':Admin/Dashboard/Widgets:projects.widget.html.twig',
            array('view_model' => $vm)
        );
    }

    public function dashboardUsersAction($max = 5)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:User')->findAll();

        $vm = [];
        //$vm['entities'] = [];
        $vm['users_count'] = count($entities);
        return $this->render(
            ':Admin/Dashboard/Widgets:users.widget.html.twig',
            array('view_model' => $vm)
        );
    }

    public function dashboardFilesAction($max = 5)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:BinaryFile')->findAll();

        $vm = [];
        //$vm['entities'] = [];
        $vm['files_count'] = count($entities);
        return $this->render(
            ':Admin/Dashboard/Widgets:files.widget.html.twig',
            array('view_model' => $vm)
        );
    }

    public function dashboardBackupsAction($max = 5)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = []; // TODO: Get backups from directory

        $vm = [];
        //$vm['entities'] = [];
        $vm['backups_count'] = count($entities);
        $vm['backups_last_date'] = count($entities);
        return $this->render(
            ':Admin/Dashboard/Widgets:backups.widget.html.twig',
            array('view_model' => $vm)
        );
    }
}
