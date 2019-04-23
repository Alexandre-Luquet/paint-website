<?php

namespace App\Form;

use App\Entity\Selection;
use App\Entity\Tableau;
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
                    'label' => 'Haut-Gauche',
                    'class' => Tableau::class,
                    'choice_label' => 'titre'
                ])
            ->add('tableau2',
                EntityType::class,
                [
                    'label' => 'Haut-Droite',
                    'class' => Tableau::class,
                    'choice_label' => 'titre'
                ])
            ->add('tableau3',
                EntityType::class,
                [
                    'label' => 'Bas-Gauche',
                    'class' => Tableau::class,
                    'choice_label' => 'titre'
                ])
            ->add('tableau4',
                EntityType::class,
                [
                    'label' => 'Bas-Droite',
                    'class' => Tableau::class,
                    'choice_label' => 'titre'
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
