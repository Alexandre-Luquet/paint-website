<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Biographie;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BiographieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //parent::buildForm($builder, $options); // TODO: Change the autogenerated stub

        $builder
            ->add('description',
                TextareaType::class,
                [
                    'label' => 'Votre biographie'
                ])
            ->add('presentation',
                TextareaType::class,
                [
                    'label' => "Votre présentation d'accueil"
                ])
            ->add('photo',
                FileType::class,
                [
                    'label' => 'Votre photo',
                    'required' => false
                ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Biographie::class,
        ]);
    }

}