<?php

namespace App\Form;

use App\Entity\ClassNameSubjects;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class FilterActivitiesFormType extends AbstractType
{
    public function __construct(Security $security)
    {
    $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->setMethod('GET')
            ->add('id', EntityType::class,[
                'class' => ClassNameSubjects::class ,
                'query_builder' => function (EntityRepository $er ) {                  
                    $user = $this->security->getUser()->getId();               
                    return $er->createQueryBuilder('u')
                    ->where('u.user ='. $user );
                },
                'choice_label' => function (ClassNameSubjects $classNameSubjects) {
                    return  'Klasa: '. $classNameSubjects->getClassName()->getName() . ' Przedmiot: ' . $classNameSubjects->getSubject()->getName();
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
            'data_class' => ClassNameSubjects::class,
        ]);
    }
}
