<?php

namespace App\Service;

use Carbon\Carbon;
use App\Services\TimeService;
use App\Repository\SchedulesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CalendarService
{

    public function __construct(ParameterBagInterface $params, SchedulesRepository $schedulesRepository, EntityManagerInterface $em)
    {
        $this->params = $params;
        $this->schedulesRepository = $schedulesRepository;
        $this->em = $em;
    }

    public function generateCalendarData($weekDays)
    {
        $calendarData = [];
        $timeRange = (new TimeService)->generateTimeRange($this->params->get('app.calendar.start_time'), $this->params->get('app.calendar.end_time'));
        $lessons   = $this->schedulesRepository->calendarByRoleOrClassId();
        $i = 0;
       // dd($lessons);
        foreach ($timeRange as $time)
        {
            $timeText = $time['start'] . ' - ' . $time['end'];
            $calendarData[$timeText] = [];

            foreach ($weekDays as $index => $day)
            {
                // $lesson = $lessons->where('weekday', $index)->where('start_time', $time['start'])->first();
                $lesson = (array_filter($lessons, function ( $lesson )  use ($index, $time){                  
                    $lesson->start_time = Carbon::parse($lesson->start_time)->format('H:i');
                    return $lesson->weekday == $index 
                     && $lesson->start_time == $time['start'];
                }));
       
                if ($lesson)
                {               
                        $i++;
                        if($i==4){
                            $i=0;
                        }
                        $background_colors = array('#037bfc', '#fca503', '#b103fc', '#ed6d05', '#fc0356');
                        $rand_background = $background_colors[$i];
 
                    $key = key($lesson);               
                    array_push($calendarData[$timeText], [
                        'class_name'   => $lesson[$key]->getClassNameSubject()->getClassName()->getName(),
                        'subject_name' => $lesson[$key]->getClassNameSubject()->getSubject()->getName(),
                        'teacher_name' => $lesson[$key]->getClassNameSubject()->getUser()->getName(),
                        'teacher_surname' => $lesson[$key]->getClassNameSubject()->getUser()->getSurName(),
                        'rowspan'      => $lesson[$key]->getDifference()/45 ?? '',
                        'color' => $rand_background
                        
                    ]);
                    
                }
                // else if (!$lessons->where('weekday', $index)->where('start_time', '<', $time['start'])->where('end_time', '>=', $time['end'])->count())
                else if(!$lesson = (array_filter($lessons, function ( $lesson )  use ($index, $time){
                    return $lesson->start_time < $time['start'] && $lesson->end_time >= $time['end'];                  
                })))
                {
                    array_push($calendarData[$timeText], 1);
                }
                else
                {
                    array_push($calendarData[$timeText], 0);
                }
            }
        }

        return $calendarData;
    }
}
