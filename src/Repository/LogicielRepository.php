<?php

namespace App\Repository;

use App\Entity\Logiciel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ordinateur>
 */
class LogicielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Logiciel::class);
    }

    public function findByOrdinateur($ip)
    {
        return $this->createQueryBuilder('l')
            ->join('l.machine_installees', 'o')
            ->where('o.ip = :ip')
            ->setParameter('ip', $ip)
            ->getQuery()
            ->getResult();
    }

    public function getLogicielsEtEventuellementOrdinateurs()
    {
        return $this->createQueryBuilder('l')
            ->select('l.nom', 'o.ip')
            ->leftjoin('l.machine_installees', 'o')
            ->getQuery()
            ->getScalarResult();
    }
}
