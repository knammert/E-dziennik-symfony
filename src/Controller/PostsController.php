<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Form\PostsFormType;
use App\Repository\PostsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class PostsController extends AbstractController
{
    public function __construct( EntityManagerInterface $em, PostsRepository $postsRepository, Security $security){
        $this->em = $em;    
        $this->postsRepository = $postsRepository; 
        $this->security = $security;
    }

    #[Route('/dashboard', name: 'posts')]
    public function index(PaginatorInterface $paginator,Request $request): Response
    {
        $posts = $this->em->getRepository(Posts::class);

        return $this->render('posts/index.html.twig', [
            'posts' => $paginator->paginate(
                $posts->findBy(array(), array('id' => 'desc')), $request->query->getInt('page', 1),5),
                
        ]);
    }
    
    #[Route('/posts/index/{id}',  methods:['GET'], name: 'post_show')]
    public function show($id): Response
    {
        $post = $this->postsRepository->find($id);
    
        return $this->render('posts/show.html.twig', [
            'post' => $post
                
        ]);
    }

    
    #[Route('/posts/create',methods:['POST','GET'], name: 'post_create')]
    public function create(Request $request){      

        $post = new Posts();
        $form = $this->createForm(PostsFormType::class, $post);
        $form->handleRequest($request);
        
            if($form->isSubmitted() && $form->isValid()){               
                $newPost = $form->getData();
                $postImage = $form->get('image_path')->getData();

                if ($postImage) {
                    $newFileName = uniqid() . '.' . $postImage->guessExtension();
                    try {
                        $postImage->move(
                            $this->getParameter('kernel.project_dir') . '/public/postUploads',
                            $newFileName
                        );
                    } catch (FileException $e) {
                        return new Response($e->getMessage());
                    }

                $post->setImagePath('/postUploads/' . $newFileName);
                }
                $post->setUser($this->security->getUser());
                $this->em->persist($newPost);
                $this->em->flush();
                $this->addFlash('status', 'Pomyślnie dodano nowy post');
                return $this->redirectToRoute('posts');
            }
        
        return $this->render('posts/create.html.twig', [
            'form'=>$form->createView(),
                
        ]);
    }

    #[Route('/posts/delete/{id}',methods:['GET','DETLE'], name: 'post_delete')]
    public function delete($id): Response
    {
        $filesystem = new Filesystem();
        $post = $this->postsRepository->find($id);
        try {
            $filesystem->remove($this->getParameter('kernel.project_dir').'/public/'.$post->getImagePath());

        } catch (FileException $e) {
            return new Response($e->getMessage());
        }
         $this->em->remove($post);
         $this->em->flush();
         $this->addFlash('status', 'Twoj post został usunięty');
        return $this->redirectToRoute('posts');
    }
}
