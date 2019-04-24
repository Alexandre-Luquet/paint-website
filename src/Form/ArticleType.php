<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',
                TextType::class,
                [
                    'label' => 'Titre'
                ])
            ->add('lieu',
                TextType::class,
                [
                    'label' => 'Lieu',
                    'required' => false
                ])
            ->add( 'dateDebut',
                DateType::class,
                [
                    'label' => 'Date début',
                    'required' => false,
                    'format' => 'dd - MM - yyyy'
                ])
            ->add( 'dateFin',
                DateType::class,
                [
                    'label' => 'Date fin',
                    'required' => false,
                    'format' => 'dd - MM - yyyy'
                ])
            ->add('horaire',
                TextType::class,
                [
                    'label' => 'Horaires',
                    'required' => false
                ])
            ->add('contenu',
                TextareaType::class,
                [
                    'label' => 'Contenu'
                ])
            ->add('journal',
                TextType::class,
                [
                    'label' => 'Journal/site'
                ])
            ->add('dateParution',
                TextType::class,
                [
                    'label' => 'Date de parution'
                ])
            ->add('image',
                FileType::class,
                [
                    'label' => 'Illustration',
                    'required' => false
                ])
            ->add('category',
                EntityType::class,
                [
                    'label' => 'Categorie',
                    // nom entité
                    'class' => Category::class,
                    // nom attribut de Category qui va s'afficher dans le select
                    'choice_label' => 'name',
                    // Pour avoir une première option vide
                    'placeholder' => 'Choisissez une catégorie'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
