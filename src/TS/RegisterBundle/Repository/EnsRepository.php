<?php

namespace TS\RegisterBundle\Repository;

/**
 * EnsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EnsRepository extends \Doctrine\ORM\EntityRepository
{
    public function getSelectedEns($startDate, $endDate, $site)
    {
        $qb = $this->createQueryBuilder('e');
        $qb 
            ->andWhere('e.date BETWEEN :start AND :end')
            ->setParameter('start', $startDate)
            ->setParameter('end',   $endDate)
        ;
        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
}
