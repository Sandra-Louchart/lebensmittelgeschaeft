<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Vorname',
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'max' => 50,
                        ])
                ],
                'attr' => [
                    'placeholder' => 'Schreiben Sie Ihren Vorname'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nachname',
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'max' => 50,
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Schreiben Sie Ihren Nachname'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-Mail',
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'max' => 100,
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Schreiben Sie IhrenEmail Adresse'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Passwort und Bestätigung müssen identisch sein',
                'label' => 'Passwort',
                'required' => true,
                'first_options' => [
                    'label'=> ' Passwort',
                    'attr' => [
                        'placeholder' => 'Schreiben Sie Ihr Passwort'
                    ]],
                'second_options' => [
                    'label' => 'Bestätigen Sie Ihr Passwort',
                    'attr' => [
                        'placeholder' => 'Schreiben Sie Ihre Passwortbestätigung',
                    ]],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Bestätigen'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
