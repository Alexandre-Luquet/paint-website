<?php

namespace App\Form;

use App\Entity\Tableau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TableauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',
                TextType::class,
                [
                    'label' => 'Titre'
                ])
            ->add('image',
                FileType::class,
                [
                    'label' => 'Tableau',
                    'data_class' => null
                ])
            ->add('annee',
                IntegerType::class,
                [
                    'label' => 'Année de réalisation'
                ])
            ->add('technique',
                TextType::class,
                [
                    'label' => 'Technique(s) utilisée'
                ])
            ->add('description',
                TextareaType::class,
                [
                    'label' => "Présentation de l'oeuvre",
                    'required' => false
                ])
            ->add('format',
                TextType::class,
                [
                    'label' => 'Dimensions'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tableau::class,
        ]);
    }
}
