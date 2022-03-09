<?php

namespace App\Controller;

use App\Entity\Grades;
use App\Form\AddGradesFormType;
use App\Entity\ClassNameSubjects;
use App\Repository\UsersRepository;
use App\Repository\GradesRepository;
use App\Form\FilterActivitiesFormType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ClassNameSubjectsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeacherGradesController extends AbstractController
{

    public function __construct(GradesRepository $gradesRepository, ClassNameSubjectsRepository $classNameSubjectsRepository, EntityManagerInterface $em, UsersRepository $usersRepository, Security $security){
        $this->gradesRepository = $gradesRepository;
        $this->classNameSubjectsRepository = $classNameSubjectsRepository;
        $this->usersRepository = $usersRepository;
        $this->security = $security;
        $this->em = $em;     
    }

    #[Route('/teacherPanel/index/', name: 'teacher_grades')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        ob_start();
        // Create filter form      
        $formFilter = $this->createForm(FilterActivitiesFormType::class);
        $formFilter->handleRequest($request);
            if($formFilter->isSubmitted() && $formFilter->isValid()){              
                $filterResult=$formFilter->getData();     
                $classNameSubject = $this->classNameSubjectsRepository->find($filterResult->id);
                $classId = $classNameSubject->getClassName()->getId();

                $users = $this->usersRepository->findBy([
                    'class_name' => $classId,
                    
                ],array('surname' => 'ASC'));  
            }
            else{
                $classNameSubject = $this->classNameSubjectsRepository->findOneBy([
                    'user' => $this->security->getUser()->getId()
                ]);
                $classId = $classNameSubject->getClassName()->getId();

                $users = $this->usersRepository->findBy([
                    'class_name' => $classNameSubject->getClassName(),
                     
                ],array('surname' => 'ASC'));                
            }        
        // End filter form

        //Get avg
        $userAvgGrade = $this->usersRepository->findUsersAvg($classId, $classNameSubject->getId());
        //END avg

        // Create new grade
        $grade = new Grades();
        $form = $this->createForm(AddGradesFormType::class, $grade);
        $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){ 
                $newGrade = $form->getData();
                $this->em->persist($newGrade);
                $this->em->flush();
                return $this->redirect($request->headers->get('referer'));
            }
        //END new grade
        return $this->render('teacherPanel/index.html.twig', [
            'activity' => $classNameSubject,
            'formFilter'=>$formFilter->createView(),
            'controller_name' => 'TeacherGradesController',
            'form'=>$form->createView(),
            'users' => $paginator->paginate(
                $users,
                $request->query->getInt('page', 1),10),
            'userAvgGrade' => $paginator->paginate(
                $userAvgGrade,
                $request->query->getInt('page', 1),10),
        ]);
    }
    
    #[Route('/teacherPanel/index/update/{gradeId}',methods:['POST','GET','PUT'], name: 'teacher_grades_update')]
    public function update($gradeId,Request $request){     
         $grade = $this->gradesRepository->find($gradeId);
         $grade->setGrade($request->get('grade'));
         $grade->setWeight($request->get('weight'));
         $grade->setSemestr($request->get('semestr'));
         $grade->setComment($request->get('comment'));
         $this->em->flush();
        
         return $this->redirect($request->headers->get('referer'));

    }


    #[Route('/changeStudentList/{id}',methods:['GET','POST'], name: 'changeStudentList')]
    public function changeStudentList($id){    
         $classNameSubjects = $this->classNameSubjectsRepository->find($id);
         $classId = $classNameSubjects->getClassName()->getId();

         $data = $this->usersRepository->findBy([
            'class_name' => $classId,
        ],array('surname' => 'ASC'));
      
        return new JsonResponse($data);
    }
}
