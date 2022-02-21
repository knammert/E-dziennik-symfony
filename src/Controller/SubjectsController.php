<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubjectsController extends AbstractController
{
    #[Route('/subjects', name: 'subjects')]
    public function index(): Response
    {
      
        return $this->render('index.html.twig');
    }
}
