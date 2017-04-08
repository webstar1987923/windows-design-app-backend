<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class DictionaryEntryRepository
 */
class DictionaryEntryRepository extends EntityRepository
{
    /**
     * @param  int $dictionary_id
     * @param  int $offset
     * @param  int $limit
     * @return array
     */
    public function getDictionaryEntriesWithProfiles(int $dictionary_id, int $offset = 0, int $limit = 0)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select([
                'dictEntry',
                'dictEntryProfile',
                'profile',
            ])
            ->from('AppBundle:DictionaryEntry', 'dictEntry')
            ->leftJoin('dictEntry.dictionaryEntryProfiles', 'dictEntryProfile')
            ->leftJoin('dictEntryProfile.profile', 'profile')
            ->where('dictEntry.dictionary = :dictionaryId')
            ->orderBy('dictEntry.position', 'ASC')
            ->setParameter('dictionaryId', $dictionary_id)
            ->setFirstResult($offset)
            ->setMaxResults($limit ?: null)
        ;

        return $qb->getQuery()->getResult();
    }
}
