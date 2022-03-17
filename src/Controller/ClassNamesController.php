<?php

namespace App\Controller;

use App\Entity\ClassNames;
use App\Form\ClassNamesType;
use App\Repository\ClassNamesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class ClassNamesController extends AbstractController
{

    public function __construct(ClassNamesRepository $classNamesRepository, EntityManagerInterface $em){
        $this->classNamesRepository = $classNamesRepository;
        $this->em = $em;     
    }

    #[Route('/adminPanel/classNames/index', name: 'classNames')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        
        // $repository = $this->em->getRepository(Subjects::class);
        // $subjects = $repository->findAll();
        $repository = $this->em->getRepository(ClassNames::class);

        // Create new class
        $className = new ClassNames();
        $form = $this->createForm(ClassNamesType::class, $className);
        $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){ 
                $newClassName = $form->getData();
                $this->em->persist($newClassName);
                $this->em->flush();
                $this->addFlash('status', 'Pomyślnie dodano nową klasę');
                return $this->redirectToRoute('classNames');
            }
        // Create new class END
       
        return $this->render('adminPanel/class_names/index.html.twig',[
            'classNames' => $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),10),
            'form'=>$form->createView()
        ]);
    }



    #[Route('/adminPanel/classNames/delete/{id}',methods:['GET','DETLE'], name: 'classNames_delete')]
    public function delete($id): Response
    {
        $className = $this->classNamesRepository->find($id);
        $this->em->remove($className);
        $this->em->flush();
        $this->addFlash('status', 'Pomyślnie usunięto klasę');

        return $this->redirectToRoute('classNames');
    }
}
