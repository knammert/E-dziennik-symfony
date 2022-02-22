<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Subjects;
use App\Entity\ClassNames;
use App\Entity\ClassNameSubjects;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ClassNameSubjectsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
             ->add('class_name', EntityType::class,[
                'class' => ClassNames::class,
                'choice_label' => 'name', 
                'label' => 'Klasa:',
                'attr' => [                
                'class' => 'form-control ',                                 
                ]
             ])
             ->add('subject', EntityType::class,[
                'class' => Subjects::class,
                'choice_label' => 'name', 
                'label' => 'Przedmiot:',
                'attr' => [                
                'class' => 'form-control ',                                 
                ]
             ])
             ->add('user', EntityType::class,[
                'class' => Users::class,
                'choice_label' => function (Users $user) {
                    return $user->getName() . ' ' . $user->getSurname();
                },
                'label' => 'Nauczyciel:',
                'attr' => [                
                'class' => 'form-control ',                                 
                ]
                ]);        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClassNameSubjects::class,
        ]);
    }
}
