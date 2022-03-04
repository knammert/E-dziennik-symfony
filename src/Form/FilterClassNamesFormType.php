<?php

namespace App\Form;

use App\Entity\ClassNames;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterClassNamesFormType extends AbstractType
{
   

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('GET')
            ->add('id', EntityType::class,[
                'class' => ClassNames::class ,           
                'choice_label' => function (ClassNames $classNames) {
                    return  'Klasa: '. $classNames->getName();
                },
                'label' => false,
                'attr' => [       
                'class' => 'form-control mb-0',                                 
                    ]
                ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClassNames::class,
        ]);
    }
}
