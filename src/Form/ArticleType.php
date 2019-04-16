<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('contenu',
                TextareaType::class,
                [
                    'label' => 'Contenu'
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
