<?php

namespace App\Entity;

use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SchedulesRepository;

#[ORM\Entity(repositoryClass: SchedulesRepository::class)]
class Schedules
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: ClassNameSubjects::class, inversedBy: 'schedules')]
    #[ORM\JoinColumn(nullable: false)]
    private $class_name_subject;

    #[ORM\Column(type: 'integer')]
    public $weekday;

    #[ORM\Column(type: 'string', length: 255)]
    public $start_time;

    #[ORM\Column(type: 'string', length: 255)]
    public $end_time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClassNameSubject(): ?ClassNameSubjects
    {
        return $this->class_name_subject;
    }

    public function setClassNameSubject(?ClassNameSubjects $class_name_subject): self
    {
        $this->class_name_subject = $class_name_subject;

        return $this;
    }

    const WEEK_DAYS = [
        '1' => 'Poniedziałek',
        '2' => 'Wtorek',
        '3' => 'Środa',
        '4' => 'Czawartek',
        '5' => 'Piatek',
    ];

    public function getWeekday(): ?string
    {
        if(isset($this->weekday))
        {
        $weekMap = [
            1 => 'PON',
            2 => 'WT',
            3 => 'ŚR',
            4 => 'CZW',
            5 => 'PT',
            6 => 'SOB',
            7 => 'ND'
            ];
            $dayOfTheWeek = $weekMap[$this->weekday];
            
        return $dayOfTheWeek;
        }
        return $this->weekday;
    }

    public function setWeekday(int $weekday): self
    {
        $this->weekday = $weekday;

        return $this;
    }

    public function getStartTime(): ?string
    {
        return $this->start_time;
    }

    public function setStartTime(string $start_time): self
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getEndTime(): ?string
    {
        return $this->end_time;
    }

    public function setEndTime(string $end_time): self
    {
        $this->end_time = $end_time;

        return $this;
    }

    public function __toString()
    {
        return $this->weekday;
    }


    public function getDifference()
    {
        return Carbon::parse($this->end_time)->diffInMinutes($this->start_time);
    }
}
