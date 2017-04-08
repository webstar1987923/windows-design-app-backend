<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;

/**
 * Class UnitRepository
 */
class UnitRepository extends EntityRepository
{
    /**
     * @param  int $id
     * @return array
     */
    public function getUnit(int $id)
    {
        $qb = $this->getUnitQueryBuilder();
        $qb
            ->where('unit.id = :unitId')
            ->setParameter('unitId', $id)
        ;

        try {
            return $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {}

        return [];
    }

    /**
     * @return QueryBuilder
     */
    private function getUnitQueryBuilder(): QueryBuilder
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select([
                'unit',
                'partial options.{id, dictionary, dictionaryEntry, quantity}',
                'dictEntry',
                'dictionary',
                'profile'
            ])
            ->from('AppBundle:Unit', 'unit')
            ->leftJoin('unit.options', 'options')
            ->leftJoin('options.dictionaryEntry', 'dictEntry')
            ->leftJoin('options.dictionary', 'dictionary')
            ->leftJoin('unit.profile', 'profile')
            ->join('unit.project', 'project')
            ;
    }
}