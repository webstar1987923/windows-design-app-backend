<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class FillingTypeRepository
 */
class FillingTypeRepository extends EntityRepository
{
    /**
     * Get list of Filling Types with associated Profiles
     *
     * @param int $offset
     * @param int $limit
     * @return array
     * @deprecated This is most likely not necessary anymore
     */
    public function getFillingTypesWithProfiles($offset = 0, $limit = 0)
    {
        $offset = $offset ?: null;
        $limit = $limit ?: null;

        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('ft, ftp, p')
            ->from('AppBundle:FillingType', 'ft')
            ->leftJoin('ft.fillingTypeProfiles', 'ftp')
            ->leftJoin('ftp.profile',  'p')
            ->orderBy('ft.position', 'ASC')
        ;

        $results = $qb->getQuery()->getArrayResult();

        $idsArray = array_unique(array_map(function($r){
            return $r['id'];
        }, $results));

        $fillingTypes = [];

        foreach ($idsArray as $idx => $id) {
            foreach ($results as $result) {
                if ($result['id'] != $id) {
                    continue;
                }
                if (!array_key_exists($idx, $fillingTypes)) {
                    $fillingTypeProfiles = [];

                    if (!empty($result['fillingTypeProfiles'])) {
                        $fillingTypeProfiles = array_map(function($ftp){
                            if (!empty($ftp['profile'])) {
                                return [
                                    'id' => $ftp['profile']['id'],
                                    'is_default' => $ftp['isDefault'],
                                ];
                            }
                        }, $result['fillingTypeProfiles']);
                    }
                    unset($result['fillingTypeProfiles']);

                    $fillingTypes[$idx] = array_merge(
                        $result,
                        array('profiles' => $fillingTypeProfiles)
                    );
                }
            }
        }

        $fillingTypes = array_slice($fillingTypes, $offset, $limit);
        return $fillingTypes;
    }
}
