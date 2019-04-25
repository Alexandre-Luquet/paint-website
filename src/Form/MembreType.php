<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',
                TextType::class,
                [
                    'label' => 'Pseudo'
                ])
            ->add('firstname',
                TextType::class,
                [
                    'label' => 'Prénom'
                ])
            ->add('lastname',
                TextType::class,
                [
                    'label' => 'Nom'
                ])
            ->add('email',
                EmailType::class,
                [
                    'label' => 'Email'
                ])
            ->add('role',
                ChoiceType::class,
                [
                    'expanded' => true,
                    'choices' =>
                        [
                            'Membre' => 'ROLE_USER',
                            'Admin' => 'ROLE_ADMIN'
                        ],
                ]

            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
