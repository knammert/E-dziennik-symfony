<?php

namespace App\Form;

use App\Entity\Schedules;
use App\Entity\ClassNameSubjects;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class SchedulesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('weekday', ChoiceType::class,[     
            'label' => 'Dzień tygodnia:',
            'attr' => [                
            'class' => 'form-control',                               
            ],
            'choices'  => [
                'Poniedziałek' => 1,
                'Wtorek' => 2,
                'Środa' => 3,
                'Czwartek' => 4,
                'Piątek' => 5,
                'Sobota' => 6,
                'Niedziela' => 7,
            ],  
         ])        
        ->add('start_time', TimeType::class,[      
            'label' => 'Godzina rozpoczęcia:',
            'input' =>'string',
            'widget' => 'single_text',         
            'attr' => [                
            'class' => 'form-control input-inline datetimepicker', 
            'data-provide' => 'datetimepicker',                              
            ],    
                 
         ]) 
         ->add('end_time', TimeType::class,[      
            'label' => 'Godzina rozpoczęcia:',
            'input' =>'string',
            'widget' => 'single_text',         
            'attr' => [                
            'class' => 'form-control input-inline datetimepicker', 
            'data-provide' => 'datetimepicker',                              
            ],    
                 
         ]) 
       
        ->add('class_name_subject', EntityType::class,[
            'class' => ClassNameSubjects::class,
            'choice_label' => function (ClassNameSubjects $classNameSubjects) {
                return  'Klasa: '. $classNameSubjects->getClassName()->getName() . ' Przedmiot: ' . $classNameSubjects->getSubject()->getName();
            },
            'label' => 'Zajęcia:',
            'attr' => [                
            'class' => 'form-control ',                                 
            ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Schedules::class,
        ]);
    }
}
