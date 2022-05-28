<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Welchen Namen möchten Sie dieser Adresse geben?',
                'attr' => [
                    'placeholder' => 'Nennen Sie Ihre Adresse'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Ihr Vorname',
                'attr' => [
                    'placeholder' => 'Geben Sie Ihren Vornamen ein'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Ihr Nachname',
                'attr' => [
                    'placeholder' => 'Geben Sie Ihren Nachnamen ein'
                ]
            ])
            ->add('company', TextType::class, [
                'label' => 'Ihr Firma',
                'required' => false,
                'attr' => [
                    'placeholder' => '(Optional) Geben Sie Ihren Firmennamen ein'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Ihr Adresse',
                'attr' => [
                    'placeholder' => 'Geben Sie Ihren Adressen ein'
                ]
            ])
            ->add('postal', TextType::class, [
                'label' => 'Ihre Postleitzahl',
                'attr' => [
                    'placeholder' => 'Geben Sie Ihre Postleitzahl ein'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ihr Stadt',
                'attr' => [
                    'placeholder' => 'Geben Sie Ihre Stadt ein '
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => 'Ihre Land',
            ])
            ->add('phone', TelType::class, [
                'label' => 'Ihr Telefonnummer',
                'attr' => [
                    'placeholder' => 'Trage Ihre Telefonnummer ein'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Bestätigen',
                'attr' => [
                    'class' => 'btn-block btn-secondary'
                ]
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
