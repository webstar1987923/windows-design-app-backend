<?php
namespace AppBundle\Helpers;


use AppBundle\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectHelper
{
    CONST ERROR_PROJECT_NOT_FOUND = 'Project with id: %s was not found';

    public static function getFileExtension($content_type)
    {
        return substr(strstr($content_type, '/'), 1);
    }

    /**
     * Get the Project by given id or throws NotFoundHttpException
     *
     * @param EntityManagerInterface $em
     * @param int $id
     *
     * @throws NotFoundHttpException when Project with $id was not found
     * @return Project
     */
    public static function getProjectByIdOrThrowNotFoundHttpException(EntityManagerInterface $em, $id)
    {
         $project = $em->getRepository('AppBundle:Project')->find($id);
        if (!$project instanceof Project) {
            throw new NotFoundHttpException(sprintf(self::ERROR_PROJECT_NOT_FOUND, $id));
        }
        return $project;
    }
}
