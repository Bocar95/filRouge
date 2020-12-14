<?php

namespace App\Repository;

use App\Entity\LivrablesPartielsApprenants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LivrablesPartielsApprenants|null find($id, $lockMode = null, $lockVersion = null)
 * @method LivrablesPartielsApprenants|null findOneBy(array $criteria, array $orderBy = null)
 * @method LivrablesPartielsApprenants[]    findAll()
 * @method LivrablesPartielsApprenants[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivrablesPartielsApprenantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LivrablesPartielsApprenants::class);
    }

    // /**
    //  * @return LivrablesPartielsApprenants[] Returns an array of LivrablesPartielsApprenants objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LivrablesPartielsApprenants
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
