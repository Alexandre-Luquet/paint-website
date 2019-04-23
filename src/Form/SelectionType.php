<?php

namespace App\Form;

use App\Entity\Selection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SelectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tableau1',
                EntityType::class,
                [
                    'label' => 'Haut-Gauche'
                ])
            ->add('tableau2',
                EntityType::class,
                [
                    'label' => 'Haut-Droite'
                ])
            ->add('tableau3',
                EntityType::class,
                [
                    'label' => 'Bas-Gauche'
                ])
            ->add('tableau4',
                EntityType::class,
                [
                    'label' => 'Bas-Droite'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Selection::class,
        ]);
    }
}
