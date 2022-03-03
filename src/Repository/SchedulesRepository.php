<?php

namespace App\Repository;

use App\Entity\Schedules;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @method Schedules|null find($id, $lockMode = null, $lockVersion = null)
 * @method Schedules|null findOneBy(array $criteria, array $orderBy = null)
 * @method Schedules[]    findAll()
 * @method Schedules[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SchedulesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Schedules::class);
        $this->security = $security;
    }
    public function calendarByRoleOrClassId()
    {
        if ($this->security->isGranted('ROLE_STUDENT')) {
            
            $qb = $this->createQueryBuilder('s')
            ->join("s.class_name_subject", "c")
            ->where('c.class_name = :ClassNameId')
            ->setParameter('ClassNameId',$this->security->getUser()->getClassName()->getId());
        }

        if ($this->security->isGranted('ROLE_TEACHER')) {
            
            $qb = $this->createQueryBuilder('s')
            ->join("s.class_name_subject", "c")
            ->where('c.user = :user_id')
            ->setParameter('user_id',$this->security->getUser()->getId());
        }
    
        if ($this->security->isGranted('ROLE_ADMIN')) {
            
            $qb = $this->createQueryBuilder('s')
            ->join("s.class_name_subject", "c")
            ->where('c.class_name = :ClassNameId')
            ->setParameter('ClassNameId',$this->security->getUser()->getClassName()->getId());
        }
        



        $query = $qb->getQuery();
        return $query->getResult();
        


        // $query->join('class_name_subjects', 'schedules.class_name_subject_id', '=', 'class_name_subjects.id');
        //         $query->where('user_id', auth()->user()->id);

        // returns an array of arrays (i.e. a raw data set)
     
    }

    // /**
    //  * @return Schedules[] Returns an array of Schedules objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Schedules
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
