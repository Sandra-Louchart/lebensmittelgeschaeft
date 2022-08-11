<?php

namespace App\Form;

use App\Entity\Products;
use Doctrine\DBAL\Types\BooleanType;
use Faker\Provider\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, [
                'label'=>'Name'
            ])
            ->add('pictureName', TextType::class, [
                'label'=>'Bildname'
            ])
            ->add('subtitle',TextType::class, [
                'label'=>'Einheit'
            ])
            ->add('description', TextType::class, [
                'label'=>'Bezeichnung'
            ])
            ->add('price', NumberType::class, [
                'label'=>'Preis',
            ])
            ->add('isBest', CheckboxType::class, [
                'label' => 'Angebote',
                'required' => false,
                'value' => 0,
            ])
            ->add('pictureFile', VichImageType::class, [
                'required' => false,
                'label' => 'Bild'
            ])
            ->add('category', null, [
                'choice_label'=> 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
