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

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Meine Email-Adresse'
            ])
            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label' => 'Mein Vorname'

            ])
            ->add('lastname', TextType::class, [
                'disabled' => true,
                'label' => 'Mein Nachname'
            ])
            ->add('old_password', PasswordType::class, [
                'label' => 'Mein aktuelles Passwort',
                'mapped'=> false,
                'attr' => [
                    'placeholder'=> 'Bitte geben Sie Ihr aktuelles Passwort ein'
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Passwort und Bestätigung müssen identisch sein',
                'label' => 'Mein neu Passwort',
                'required' => true,
                'first_options' => [
                    'label'=> ' Passwort',
                    'attr' => [
                        'placeholder' => 'Schreiben Sie Ihr Passwort'
                    ]],
                'second_options' => [
                    'label' => 'Bestätigen Sie Ihr neu Passwort',
                    'attr' => [
                        'placeholder' => 'Schreiben Sie Ihre neu Passwortbestätigung',
                    ]],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Aktualisieren'
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
