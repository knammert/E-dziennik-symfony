<?php

namespace App\Controller;

use App\Form\EditMeFormType;
use App\Repository\UsersRepository;
use App\Form\ChangePasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\ProfilePictureUploadService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MeController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, UsersRepository $usersRepository, Security $security){
        $this->usersRepository = $usersRepository;
        $this->em = $em;     
        $this->security = $security;
    }

    #[Route('/me/index', name: 'me')]
    public function index(): Response
    {
        return $this->render('me/profile.html.twig', [
            'controller_name' => 'MeController',
        ]);
    }

    #[Route('/me/edit', name: 'me_edit')]
    public function edit(Request $request, ProfilePictureUploadService $profilePictureUploadService): Response
    {
        $me = $this->security->getUser();
        $form = $this->createForm(EditMeFormType::class,$this->security->getUser());
       
        $form->handleRequest($request);
        $avatar = $form->get('avatar')->getData();
            if($form->isSubmitted() && $form->isValid()){     
                $newFileName = $profilePictureUploadService->uploadProfilePicture($avatar);
                $me->setAvatar('/uploads/' . $newFileName);
                $me->setName($form->get('name')->getData());
                $me->setSurname($form->get('surname')->getData()); 
                $this->em->flush();
                $this->addFlash('status', 'Profil został zaaktualizowany');
                return $this->redirectToRoute('me');
            }

        return $this->render('me/edit.html.twig', [
            'form'=>$form->createView(),      
        ]);
    }

    #[Route('/me/changePassword', name: 'me_change_password')]
    public function changePassword(Request $request, UserPasswordHasherInterface $userPasswordHasher ): Response
    {
        $me = $this->security->getUser();
        
        $form = $this->createForm(ChangePasswordFormType::class, $me );   
        $form->handleRequest($request);
            
            if($form->isSubmitted() && $form->isValid()){      

                $oldPassword = $form->get('password')->getData();         
                if (!$userPasswordHasher->isPasswordValid($me, $oldPassword)) {
                    $this->addFlash('status', 'Wprowadzone aktualne hasło jest niepoprwane');
                    return $this->redirectToRoute('me_change_password'); 
                }

                $newHashedPassword = $userPasswordHasher->hashPassword(
                    $me,
                    $form->get('plainPassword')->getData()
                );

                $this->usersRepository->upgradePassword($me, $newHashedPassword);
                $this->addFlash('status', 'Pomyślnie zmieniono hasło');
                return $this->redirectToRoute('app_logout'); 
               
            }

        return $this->render('me/changePassword.html.twig', [
            'form' => $form->createView(),      
        ]);
    }

    #[Route('/me/deleteAccountSite',methods:['GET'], name: 'me_delete_account_site')]
    public function showDeleteAccountSite(): Response
    {
         return $this->render('me/deleteAccount.html.twig', [         
        ]);
    }

    #[Route('/me/deleteAccount', name: 'me_delete_account')]
    public function delete(): Response
    {  
        $user = $this->security->getUser();
        $user->setRoles([]);
        $this->em->flush();
        $this->addFlash('status', 'Twoje konto zostało dezaktywowane');
        return $this->redirectToRoute('app_logout');
    }

}
