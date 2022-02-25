<?php

namespace App\Repository;

use App\Entity\ClassNameSubjects;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method ClassNameSubjects|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClassNameSubjects|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClassNameSubjects[]    findAll()
 * @method ClassNameSubjects[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassNameSubjectsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, ClassNameSubjects::class);
        $this->security = $security;
    }

    // SELECT  IFNULL(SUM(g.grade * g.weight) / SUM(g.weight), NULL) as avg
    // FROM class_name_subjects c
    //          LEFT JOIN grades g on c.id = g.class_name_subject_id AND g.user_id = 226
    // WHERE c.class_name_id = 73
    // GROUP BY c.id;
    public function findUserAvg()
    {
        //dd($classId,$ClassNameSubjectId);
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        SELECT  IFNULL(SUM(g.grade * g.weight) / SUM(g.weight), NULL) as avg
        FROM class_name_subjects c
                LEFT JOIN grades g on c.id = g.class_name_subject_id AND g.user_id = :user_id
        WHERE c.class_name_id = :class_name_id
        GROUP BY c.id;
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(array('user_id' => $this->security->getUser()->getId(), 'class_name_id' => $this->security->getUser()->getClassName()->getId()));

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
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
