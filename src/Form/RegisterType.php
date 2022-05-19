<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Vorname',
                'attr' => [
                    'placeholder' => 'Schreiben Sie Ihren Vorname'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nachname',
                'attr' => [
                    'placeholder' => 'Schreiben Sie Ihren Nachname'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-Mail',
                'attr' => [
                    'placeholder' => 'Schreiben Sie IhrenEmail Adresse'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Passwort',
                'attr' => [
                    'placeholder' => 'Schreiben Sie Ihr Passwort'
                ]
            ])
            ->add('password_confirm', PasswordType::class, [
                'label' => 'Bestätigen Sie Ihr Passwort',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Bestätigen Sie Ihr Passwort'
                ]
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
