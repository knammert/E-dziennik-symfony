<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name' ,TextType::class ,[
                'label' => false,
                'attr' => [
                    'autocomplete' => 'name',                     
                    'class' => 'form-control ',
                    'placeholder' => 'Imię'
                ],
            ])
            ->add('surname' ,TextType::class ,[
                'label' => false,
                'attr' => [
                    'autocomplete' => 'surname',                     
                    'class' => 'form-control',
                    'placeholder' => 'Nazwisko'
                ],
            ])
            ->add('pesel' ,IntegerType::class ,[
                'label' => false,
                'attr' => [
                    'autocomplete' => 'pesel',                     
                    'class' => 'form-control',
                    'placeholder' => 'Pesel',               
                ],
                'constraints' => [
                    new Length([
                        'min' => 11,
                        'maxMessage' => 'Pesel powninien składać się z 11 cyfr',
                        'max' => 11,
                    ]),
                ],
                
            ])
            ->add('email' ,TextType::class ,[
                'label' => false,
                'attr' => [
                    'autocomplete' => 'email',                     
                    'class' => 'form-control',
                    'placeholder' => 'Email'
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'first_options' => ['label' => false ,'attr' => ['placeholder' => 'Hasło']],
                'second_options' => ['label' => false, 'attr' => ['placeholder' => 'Powtórz hasło']],
                'label' => false,
                'invalid_message' => 'Podane hasła nie zgadzają',
                'attr' => [
                    'autocomplete' => 'plainPassword',                     
                    'class' => 'form-control',
                    'placeholder' => 'Haslo',
                    'autocomplete' => 'new-password'],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Podaj hasło',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Twoje hasło powinno mieć przynajmniej {{ limit }} znaków',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
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
