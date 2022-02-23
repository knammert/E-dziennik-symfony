<?php

namespace App\Controller;

use App\Entity\Grades;
use App\Form\AddGradesFormType;
use App\Entity\ClassNameSubjects;
use App\Repository\UsersRepository;
use App\Form\FilterActivitiesFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ClassNameSubjectsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeacherGradesController extends AbstractController
{

    public function __construct(ClassNameSubjectsRepository $classNameSubjectsRepository, EntityManagerInterface $em, UsersRepository $usersRepository){
        $this->classNameSubjectsRepository = $classNameSubjectsRepository;
        $this->usersRepository = $usersRepository;
        $this->em = $em;     
    }

    #[Route('/teacherPanel/index/', name: 'teacher_grades')]
    public function index(Request $request): Response
    {

        $users = $this->usersRepository->findBy([
            'class_name' => 73,
        ]);

       // $users = $this->usersRepository->filterByClass();


        // Create filter form
      
        $formFilter = $this->createForm(FilterActivitiesFormType::class);
        $formFilter->handleRequest($request);
            if($formFilter->isSubmitted() && $formFilter->isValid()){              
                $filterResult=$formFilter->getData();
                
                $classNameSubjects = $this->classNameSubjectsRepository->find($filterResult->id);
                $classId = $classNameSubjects->getClassName()->getId();

                $users = $this->usersRepository->findBy([
                    'class_name' => $classId,
                ]);
       
            }
        // Create filter form END

        // Create new activity
        $grade = new Grades();
        $form = $this->createForm(AddGradesFormType::class, $grade);
        $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){ 
                $newGrade = $form->getData();
                $this->em->persist($newGrade);
                $this->em->flush();
                return $this->redirectToRoute('teacher_grades');
            }
        // Create new activity END


        return $this->render('teacherPanel/index.html.twig', [
            'users'=> $users,
            'formFilter'=>$formFilter->createView(),
            'controller_name' => 'TeacherGradesController',
            'form'=>$form->createView(),
        ]);
    }

    #[Route('/changeStudentList/{id}',methods:['GET','POST'], name: 'changeStudentList')]
    public function changeStudentList($id){
        
        
         $classNameSubjects = $this->classNameSubjectsRepository->find($id);
         $classId = $classNameSubjects->getClassName()->getId();

         $data = $this->usersRepository->findBy([
            'class_name' => $classId,
        ]);
      
        return new JsonResponse($data);
    }
}
