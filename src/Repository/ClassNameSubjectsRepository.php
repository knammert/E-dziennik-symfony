<?php

namespace App\Repository;

use App\Entity\ClassNameSubjects;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClassNameSubjects|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClassNameSubjects|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClassNameSubjects[]    findAll()
 * @method ClassNameSubjects[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassNameSubjectsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClassNameSubjects::class);
    }

    // /**
    //  * @return ClassNameSubjects[] Returns an array of ClassNameSubjects objects
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
    public function findOneBySomeField($value): ?ClassNameSubjects
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
