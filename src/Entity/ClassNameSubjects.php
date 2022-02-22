<?php

namespace App\Entity;

use App\Repository\ClassNameSubjectsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassNameSubjectsRepository::class)]
class ClassNameSubjects
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: ClassNames::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $class_name;

    #[ORM\ManyToOne(targetEntity: Subjects::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $subject;

    #[ORM\ManyToOne(targetEntity: Users::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

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
}
