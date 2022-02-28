<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FilterUsersFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('GET')
            ->add('phrase',TextType::class ,[
                'label' => false,
                'required' =>false,
                'attr' => [                
                    'class' => 'form-control ',               
                ],
            ])
            ->add('roles', ChoiceType::class,[     
                'label' => false,
                'attr' => [                
                'class' => 'form-control',                               
                ],
                'choices'  => [
                    'Brak' => null,
                    'Uczeń' => 'ROLE_STUDENT',
                    'Nauczyciel' => 'ROLE_TEACHER',
                    'Administrator' => 'ROLE_ADMIN',
                ],  
             ]) ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
