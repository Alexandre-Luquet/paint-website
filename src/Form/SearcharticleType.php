<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearcharticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->setMethod('GET')
        ->add(
            'title',
            TextType::class,
            [
                'label' => 'Titre',
                'required' => false
            ]
        )
        ->add(
            'category',
            EntityType::class,[
                'class' => Category::class,
                'label' => 'Catégorie',
                'placeholder' => 'Choisissez une catégorie',
                'choice_label' => 'name',
                'required' => false
            ]
        )
        ->add(
            'start_date',
            TextType::class,
            [
                'label' => 'Date début',
                'required' => false
            ]
        )
        ->add(
            'end_date',
            TextType::class,
            [
                'label' => 'Date de fin',
                'required' => false
            ]
        )
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

        ]);
    }
}
