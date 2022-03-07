<?php

namespace App\Controller;

use App\Entity\Posts;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PostsController extends AbstractController
{
    public function __construct( EntityManagerInterface $em){
        $this->em = $em;    
        // $this->postRepository = $postsRepository; 
    }


    #[Route('/posts/index', name: 'posts')]
    public function index(PaginatorInterface $paginator,Request $request): Response
    {
        $posts = $this->em->getRepository(Posts::class);
    

        return $this->render('posts/index.html.twig', [
            'posts' => $paginator->paginate(
                $posts->findAll(), $request->query->getInt('page', 1),5),
                
        ]);
    }
}
