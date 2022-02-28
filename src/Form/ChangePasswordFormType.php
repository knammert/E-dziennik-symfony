<?php

namespace App\Form;


use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder                
            ->add('password',PasswordType::class ,[
               // 'mapped' => true,
                'label' => false,
                'attr' => [                
                    'class' => 'form-control ',          
                    'placeholder' => 'Stare hasło',                
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => false ,'attr' => ['placeholder' => 'Hasło']],
                'second_options' => ['label' => false, 'attr' => ['placeholder' => 'Powtórz hasło']],
                'label' => false,
                'invalid_message' => 'Podane hasła nie zgadzają się',
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
