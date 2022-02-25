<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use App\Repository\GradesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ClassNameSubjectsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class StudentGradesController extends AbstractController
{
    public function __construct(GradesRepository $gradesRepository, ClassNameSubjectsRepository $classNameSubjectsRepository, 
    EntityManagerInterface $em, UsersRepository $usersRepository, Security $security){
        $this->gradesRepository = $gradesRepository;
        $this->classNameSubjectsRepository = $classNameSubjectsRepository;
        $this->security = $security;
        $this->em = $em;     
    }

    #[Route('/studentPanel/index', name: 'student_grades')]
    public function index(PaginatorInterface $paginator,Request $request): Response
    {
        //Retriving activities
        $classNameSubjects = $this->classNameSubjectsRepository->findBy([
            'class_name' => $this->security->getUser()->getClassName()->getId()
        ]);
        //Retriving average grade
        $userAvgGrade = $this->classNameSubjectsRepository->findUserAvg();
        //END average grade

        
        return $this->render('studentPanel/index.html.twig', [
            'classNameSubjects' => $paginator->paginate(
                $classNameSubjects,
                $request->query->getInt('page', 1),10),
            'userAvgGrade' => $paginator->paginate(
                $userAvgGrade,
                $request->query->getInt('page', 1),10),

        ]);
    }
}
