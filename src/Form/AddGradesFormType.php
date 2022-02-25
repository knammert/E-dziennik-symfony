<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Grades;
use App\Entity\ClassNameSubjects;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddGradesFormType extends AbstractType
{
    public function __construct(Security $security)
    {
       $this->security = $security;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
            
        $builder
        ->add('grade', ChoiceType::class,[     
            'label' => 'Ocena:',
            'attr' => [                
            'class' => 'form-control',                               
            ],
            'choices'  => [
                '1' => 1,
                '1+' => 1.5,
                '2-' => 1.75,
                '2' => 2,
                '2+' => 2.5,
                '3-' => 2.75,
                '3' => 3,
                '3+' => 3.5,
                '4-' => 3.75,
                '4' => 4,
                '4+' => 4.5,
                '5-' => 4.75,
                '5' => 5,
                '5+' => 5.5,
                '6-' => 5.75,
                '6' => 6,
            ],  
         ])
            ->add('weight', ChoiceType::class,[     
                'label' => 'Waga:',
                'attr' => [                
                'class' => 'form-control',                               
                ],
                'choices'  => [
                    '1' => 1,
                    '1.5' => 1.5,
                    '1.75' => 1.75,
                    '2' => 2,
                    '2.5' => 2.5,
                    '3.75' => 2.75,
                    '3' => 3,
                    '3.5' => 3.5,
                    '3.75' => 3.75,
                    '4' => 4,
                    '4.5' => 4.5,
                    '4.75' => 4.75,
                    '5' => 5,
                    '5.5' => 5.5,
                    '5.75' => 5.75,
                    '6' => 6,
                ],  
             ])
            ->add('comment',TextType::class ,[
                'label' => 'Komentarz',
                'attr' => [                
                    'class' => 'form-control ',               
                ],
            ])
            
            // ->add('created_at')
            // ->add('updated_at')
            ->add('semestr', ChoiceType::class,[     
                'label' => 'Semestr:',
                'attr' => [                
                'class' => 'form-control',                               
                ],
                'choices'  => [
                    'Zimowy' => 1,
                    'Letni' => 2,
                ],  
             ])
             ->add('class_name_subject', EntityType::class,[
                'class' => ClassNameSubjects::class,
                'query_builder' => function (EntityRepository $er ) {                  
                    $user = $this->security->getUser()->getId();               
                    return $er->createQueryBuilder('u')
                    ->where('u.user ='. $user );
                },
                'choice_label' => function (ClassNameSubjects $classNameSubjects) {
                    return  'Klasa: '. $classNameSubjects->getClassName()->getName() . ' Przedmiot: ' . $classNameSubjects->getSubject()->getName();
                },
                'label' => 'Zajęcia:',
                'attr' => [       
                'class' => 'form-control ',                                 
                    ]
                ])
                ->add('user', EntityType::class,[
                    'class' => Users::class,
                    'choice_label' => function (Users $user) {
                        return $user->getName() . ' ' . $user->getSurname();
                    },                 
                    'label' => 'Uczeń:',
                    'attr' => [                
                    'class' => 'form-control ',                                               
                        ]                       
                    ]);
            ;

            
        

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Grades::class,
        ]);
    }
}
