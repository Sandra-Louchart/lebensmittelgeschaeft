<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Vorname'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nachname'
                ]
            ])

            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'E-Mail-Addresse'
                ]
            ])
            ->add('subject', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Thema'
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Text'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Send',
                'attr' => [
                    'class' => 'btn-block btn-success'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
