<?php

namespace App\Controller;

use App\Entity\Subjects;
use App\Form\SubjectFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubjectsRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class SubjectsController extends AbstractController
{
    private $em;

    public function __construct(SubjectsRepository $subjectsRepository, EntityManagerInterface $em){
        $this->subjectsRepository = $subjectsRepository;
        $this->em = $em;     
    }

    #[Route('/adminPanel/subjects/index', name: 'subjects')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        
        // $repository = $this->em->getRepository(Subjects::class);
        // $subjects = $repository->findAll();
        $repository = $this->em->getRepository(Subjects::class);

        // Create new subject
        $subject = new Subjects();
        $form = $this->createForm(SubjectFormType::class, $subject);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){ 
            $newSubject = $form->getData();
            $this->em->persist($newSubject);
            $this->em->flush();
            return $this->redirectToRoute('subjects');
        }
        // Create new subject END
       
        return $this->render('adminPanel/subjects/index.html.twig',[
            'subjects' => $paginator->paginate(
                $repository->findAll(),$request->query->getInt('page', 1),10),
            'form'=>$form->createView()
        ]);
    }

    #[Route('/adminPanel/subjects/delete/{id}',methods:['GET','DETLE'], name: 'subjects_delete')]
    public function delete($id): Response
    {
        $subject = $this->subjectsRepository->find($id);
        $this->em->remove($subject);
        $this->em->flush();

        return $this->redirectToRoute('subjects');
    }

}
