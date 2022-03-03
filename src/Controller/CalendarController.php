<?php

namespace App\Controller;

use App\Entity\Schedules;
use App\Service\CalendarService;
use App\Entity\ClassNameSubjects;
use App\Repository\ClassNamesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CalendarController extends AbstractController
{
    public function __construct(ClassNamesRepository $classNamesRepository, EntityManagerInterface $em){
        $this->classNamesRepository = $classNamesRepository;
        $this->em = $em;     
    }
    
    #[Route('/calendar', name: 'calendar')]
    public function index(CalendarService $calendarService): Response
    {
        $this->addFlash('success', 'xd');
         $weekDays = Schedules::WEEK_DAYS;
         $calendarData = $calendarService->generateCalendarData($weekDays);
         $activities  = $this->classNamesRepository->findAll();

        return $this->render('calendar/index.html.twig', [
            'weekDays' => $weekDays,
            'calendarData' =>  $calendarData,
            'activities' => $activities
        ]);
    }
}
