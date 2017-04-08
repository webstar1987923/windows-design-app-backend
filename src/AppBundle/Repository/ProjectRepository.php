<?php

namespace AppBundle\Repository;

use Doctrine\ORM\NoResultException;
use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{
    public function getProject($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select([
                'project',
                'quote',
                'units',
                'accessories',
                'binaryFiles',
            ])
            ->from('AppBundle:Project', 'project')
            ->leftJoin('project.quotes', 'quote')
            ->leftJoin('quote.units', 'units')
            ->leftJoin('quote.accessories', 'accessories')
            ->leftJoin('project.binaryFiles', 'binaryFiles')
            ->where('project.id = :projectId')
            ->setParameter('projectId', $id)
        ;

        try {
            $project = $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            return [];
        }

        return $project;
    }
}