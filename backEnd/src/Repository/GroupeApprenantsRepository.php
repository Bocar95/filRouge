<?php

namespace App\Repository;

use App\Entity\GroupeApprenants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GroupeApprenants|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupeApprenants|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupeApprenants[]    findAll()
 * @method GroupeApprenants[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupeApprenantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupeApprenants::class);
    }

    // /**
    //  * @return GroupeApprenants[] Returns an array of GroupeApprenants objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GroupeApprenants
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
