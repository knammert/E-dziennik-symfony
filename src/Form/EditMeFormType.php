<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EditMeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class ,[
                'label' => 'Imię',
                'attr' => [                
                    'class' => 'form-control ',               
                ],
            ])
            ->add('surname',TextType::class ,[
                'label' => 'Nazwisko',
                'attr' => [                
                    'class' => 'form-control ',               
                ],
            ])
            ->add('avatar',FileType::class ,[
                'data_class' => null,
                'required' =>false,
                'label' => 'Avatar',
                'attr' => [                
                    'class' => 'form-control-file',               
                ],
            ])
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
