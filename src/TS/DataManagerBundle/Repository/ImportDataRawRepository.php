<?php

namespace TS\DataManagerBundle\Repository;

use Doctrine\ORM\QueryBuilder;
/**
 * ImportDataRawRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImportDataRawRepository extends \Doctrine\ORM\EntityRepository
{
    public function getSelectedData($startDate, $endDate)
    {
        $qb = $this->createQueryBuilder('i');
        $qb 
            ->andWhere('i.date BETWEEN :start AND :end')
            ->setParameter('start', $startDate)
            ->setParameter('end',   $endDate)
        ;
        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
}
