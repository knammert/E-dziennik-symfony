<?php

namespace App\Entity;

use App\Repository\ClassNameSubjectsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassNameSubjectsRepository::class)]
class ClassNameSubjects
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public $id;

    #[ORM\ManyToOne(targetEntity: ClassNames::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $class_name;

    #[ORM\ManyToOne(targetEntity: Subjects::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $subject;

    #[ORM\ManyToOne(targetEntity: Users::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\OneToMany(mappedBy: 'class_name_subject', targetEntity: Schedules::class, orphanRemoval: true)]
    private $schedules;

    #[ORM\OneToMany(mappedBy: 'class_name_subject', targetEntity: Grades::class, orphanRemoval: true)]
    private $grades;

    public function __construct()
    {
        $this->schedules = new ArrayCollection();
        $this->grades = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClassName(): ?ClassNames
    {
        return $this->class_name;
    }

    public function setClassName(?ClassNames $class_name): self
    {
        $this->class_name = $class_name;

        return $this;
    }

    public function getSubject(): ?Subjects
    {
        return $this->subject;
    }

    public function setSubject(?Subjects $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Schedules>
     */
    public function getSchedules(): Collection
    {
        return $this->schedules;
    }

    public function addSchedule(Schedules $schedule): self
    {
        if (!$this->schedules->contains($schedule)) {
            $this->schedules[] = $schedule;
            $schedule->setClassNameSubject($this);
        }

        return $this;
    }

    public function removeSchedule(Schedules $schedule): self
    {
        if ($this->schedules->removeElement($schedule)) {
            // set the owning side to null (unless already changed)
            if ($schedule->getClassNameSubject() === $this) {
                $schedule->setClassNameSubject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Grades>
     */
    public function getGrades(): Collection
    {
        return $this->grades;
    }

    public function addGrade(Grades $grade): self
    {
        if (!$this->grades->contains($grade)) {
            $this->grades[] = $grade;
            $grade->setClassNameSubject($this);
        }

        return $this;
    }

    public function removeGrade(Grades $grade): self
    {
        if ($this->grades->removeElement($grade)) {
            // set the owning side to null (unless already changed)
            if ($grade->getClassNameSubject() === $this) {
                $grade->setClassNameSubject(null);
            }
        }

        return $this;
    }
}
