<?php

namespace App\Controller;

use App\Form\FilterUsersFormType;
use App\Repository\UsersRepository;
use App\Repository\ClassNamesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
    public function index(Request $request, PaginatorInterface $paginator,): Response
    {
        //Getting all users and classes for edit 

        $users  = $this->usersRepository->findBy(array(), array('surname' => 'ASC'));
        $classes = $this->classNamesRepository->findAll();



        $formFilter = $this->createForm(FilterUsersFormType::class);
        $formFilter->handleRequest($request);
            if($formFilter->isSubmitted() && $formFilter->isValid()){                
                $filterResult = $formFilter->getData();  
              // dd($filterResult);   
                $qb = $this->usersRepository->createQueryBuilder('u')
                ->orderBy('u.surname', 'ASC');

                 if($filterResult['phrase'] !=null){
                    $qb -> where('u.surname LIKE :phrase')
                    ->setParameter('phrase', '%'.$filterResult['phrase'].'%');
                 }
                 if($filterResult['roles'] !=null){
                    $qb -> where('u.roles LIKE :roles')
                    ->setParameter('roles', '%'.$filterResult['roles'].'%');
                 }
      
                $query = $qb->getQuery();
                $users = $query->execute();                               
            }
        return $this->render('/adminPanel/users/index.html.twig', [
            'users' => $paginator->paginate(
                $users,
                $request->query->getInt('page', 1),10),
            'classes' => $classes,
            'formFilter'=>$formFilter->createView(),
        ]);
    }

    #[Route('/adminPanel/users/index/update/{userId}',methods:['POST','GET','PUT'], name: 'user_update')]
    public function update($userId, Request $request){      

         $user = $this->usersRepository->find($userId);
         $class =  $this->classNamesRepository->find($request->get('className'));
         $user->setClassName($class);
         $user->setRoles([$request->get('role')]);
         $this->em->flush();
         $this->addFlash('status', 'Użytkownik został zaakutalizowany');
        
         return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/adminPanel/users/index/delete/{id}',methods:['GET','DETLE'], name: 'user_delete')]
    public function delete($id): Response
    {
            
        $user = $this->usersRepository->find($id);
        $this->em->remove($user);
        $this->em->flush();
        $this->addFlash('status', 'Uzytkownik został usunięty');

        return $this->redirectToRoute('users');
    }


}
