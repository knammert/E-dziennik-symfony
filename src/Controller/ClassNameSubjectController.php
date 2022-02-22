<?php

namespace App\Controller;

use App\Entity\ClassNameSubjects;
use App\Form\ClassNameSubjectsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ClassNameSubjectsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClassNameSubjectController extends AbstractController
{
    private $em;

    public function __construct(ClassNameSubjectsRepository $classNameSubjectsRepository, EntityManagerInterface $em){
        $this->classNameSubjectsRepository = $classNameSubjectsRepository;
        $this->em = $em;     
    }


    #[Route('/adminPanel/activities/index', name: 'activities')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
         // $repository = $this->em->getRepository(Subjects::class);
        // $subjects = $repository->findAll();
        $repository = $this->em->getRepository(ClassNameSubjects::class);

        // Create new subject
        $activity = new ClassNameSubjects();
        $form = $this->createForm(ClassNameSubjectsFormType::class, $activity);
        $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){ 
                $newActivity = $form->getData();
                $this->em->persist($newActivity);
                $this->em->flush();
                return $this->redirectToRoute('activities');
            }
        // Create new subject END
       
        return $this->render('/adminPanel/activities/index.html.twig',[
            'class_name_subjects' => $paginator->paginate(
                $repository->findAll(),$request->query->getInt('page', 1),10),
             'form'=>$form->createView()
        ]);
    }
}
