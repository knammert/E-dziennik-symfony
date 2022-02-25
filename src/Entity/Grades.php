<?php

namespace App\Entity;

use DateTime;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GradesRepository;

#[ORM\Entity(repositoryClass: GradesRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Grades
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'grades')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: ClassNameSubjects::class, inversedBy: 'grades')]
    #[ORM\JoinColumn(nullable: false)]
    private $class_name_subject;

    #[ORM\Column(type: 'float')]
    private $grade;

    #[ORM\Column(type: 'float')]
    private $weight;

    #[ORM\Column(type: 'string', length: 255)]
    private $comment;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime')]
    public $created_at;

    
    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'update')]
    public $updated_at;

    #[ORM\Column(type: 'integer')]
    private $semestr;



    public function getId(): ?int
    {
        return $this->id;
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

    public function getClassNameSubject(): ?ClassNameSubjects
    {
        return $this->class_name_subject;
    }

    public function setClassNameSubject(?ClassNameSubjects $class_name_subject): self
    {
        $this->class_name_subject = $class_name_subject;

        return $this;
    }

    public function getGrade(): ?float
    {
        return $this->grade;
    }

    public function setGrade(float $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    // public function setCreatedAt(\DateTime $created_at): self
    // {
    //     $this->created_at = $created_at;

    //     return $this;
    // }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updated_at;
    }

    // public function setUpdatedAt(\DateTime $updated_at): self
    // {
    //     $this->updated_at = $updated_at;

    //     return $this;
    // }

    public function getSemestr(): ?int
    {
        return $this->semestr;
    }

    public function setSemestr(int $semestr): self
    {
        $this->semestr = $semestr;

        return $this;
    }
}
