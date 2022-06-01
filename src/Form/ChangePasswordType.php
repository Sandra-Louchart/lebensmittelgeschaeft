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
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Passwort und Bestätigung müssen identisch sein',
                'required' => true,
                'first_options' => [
                    'label'=> ' Mein neues Passwort',
            ],
                'second_options' => [
                    'label' => 'Neues Passwort bestätigen ',
              ],
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
