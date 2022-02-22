<?php

namespace App\Repository;

use App\Entity\ClassNames;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClassNames|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClassNames|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClassNames[]    findAll()
 * @method ClassNames[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassNamesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClassNames::class);
    }

    // /**
    //  * @return ClassNames[] Returns an array of ClassNames objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ClassNames
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
