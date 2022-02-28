<?php

namespace App\Controller;

use App\Repository\ClassNamesRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsersController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, ClassNamesRepository $classNamesRepository, UsersRepository $usersRepository){
        $this->classNamesRepository = $classNamesRepository;
        $this->usersRepository = $usersRepository;
        $this->em = $em;     
    }

    #[Route('/adminPanel/users/index', name: 'users')]
    public function index(): Response
    {

        $users = $this->usersRepository->findAll();
        $classes = $this->classNamesRepository->findAll();

        return $this->render('/adminPanel/users/index.html.twig', [
            'users' => $users,
            'classes' => $classes,
        ]);
    }

    #[Route('/adminPanel/index/update/{userId}',methods:['POST','GET','PUT'], name: 'user_update')]
    public function update($userId, Request $request){      

         $user = $this->usersRepository->find($userId);
         $class =  $this->classNamesRepository->find($request->get('className'));
         $user->setClassName($class);
         $user->setRoles([$request->get('role')]);
         $this->em->flush();
        
         return $this->redirect($request->headers->get('referer'));
    }


}
