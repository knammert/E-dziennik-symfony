<?php

namespace App\Controller;

use App\Entity\Schedules;
use App\Service\CalendarService;
use App\Entity\ClassNameSubjects;
use App\Form\FilterClassNamesFormType;
use App\Repository\ClassNamesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CalendarController extends AbstractController
{
    public function __construct(ClassNamesRepository $classNamesRepository, EntityManagerInterface $em){
        $this->classNamesRepository = $classNamesRepository;
        $this->em = $em;     
    }
    
    #[Route('/calendar', name: 'calendar')]
    public function index(CalendarService $calendarService,Request $request): Response
    {   
        $weekDays = Schedules::WEEK_DAYS;        
        $activities  = $this->classNamesRepository->findAll();

        $formFilter = $this->createForm(FilterClassNamesFormType::class);
        $formFilter->handleRequest($request);
            if($formFilter->isSubmitted() && $formFilter->isValid()){                
                $filterResult = $formFilter->getData();  
                $filterResult = $filterResult->id->id;
            //   // dd($filterResult);   
            //     $qb = $this->usersRepository->createQueryBuilder('u')
            //     ->orderBy('u.surname', 'ASC');

            //      if($filterResult['phrase'] !=null){
            //         $qb -> where('u.surname LIKE :phrase')
            //         ->setParameter('phrase', '%'.$filterResult['phrase'].'%');
            //      }
            //      if($filterResult['roles'] !=null){
            //         $qb -> where('u.roles LIKE :roles')
            //         ->setParameter('roles', '%'.$filterResult['roles'].'%');
            //      }
      
            //     $query = $qb->getQuery();
            //     $users = $query->execute();              
            $calendarData = $calendarService->generateCalendarData($weekDays, $filterResult);                 
            }
            else {
                $calendarData = $calendarService->generateCalendarData($weekDays);
            }
      

        return $this->render('calendar/index.html.twig', [
            'weekDays' => $weekDays,
            'calendarData' =>  $calendarData,
            'activities' => $activities,
            'formFilter'=>$formFilter->createView(),
        ]);
    }
}
