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

            ])
            ->add('firstname', TextType::class, [
                'label' => 'Ihr Vorname',

            ])
            ->add('lastname', TextType::class, [
                'label' => 'Ihr Nachname',
            ])
            ->add('company', TextType::class, [
                'label' => 'Ihre Firma',
                'required' => false,
                'attr' => [
                    'placeholder' => '(Optional)'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Ihre Adresse',
            ])
            ->add('postal', TextType::class, [
                'label' => 'Ihre Postleitzahl',

            ])
            ->add('city', TextType::class, [
                'label' => 'Ihre Stadt',

            ])
            ->add('country', CountryType::class, [
                'label' => 'Ihr Land',
            ])
            ->add('phone', TelType::class, [
                'label' => 'Ihre Telefonnummer',

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
