<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RateRepository extends EntityRepository
{
    public function findAllOlderThanTwoDays()
    {

        $query = $this->createQueryBuilder('rate')
            ->where('rate.date < :date')
            ->setParameter('date', new \DateTime(date('Y-m-d', strtotime('-1 day', strtotime(date('r'))))))
            ->getQuery()
        ;

        return $query->getResult();
    }
}