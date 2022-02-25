<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsersController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, UsersRepository $usersRepository){
        $this->usersRepository = $usersRepository;
        $this->em = $em;     
    }

    #[Route('/adminPanel/users/index', name: 'users')]
    public function index(): Response
    {

        $users = $this->usersRepository->findAll();

        return $this->render('/adminPanel/users/index.html.twig', [
            'users' => $users,
        ]);
    }
}
