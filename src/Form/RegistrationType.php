<?php

namespace App\Form;

use App\Entity\Utilisateurs;
use App\Entity\Personnel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\UserInterface;
 use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user_name')
            ->add('user_firstname')
            ->add('user_email')
            ->add('user_password', PasswordType::class)
            ->add('user_passwordConfirm', PasswordType::class)
            ->add('user_phone')
            ->add('user_adresse')
            ->add('Personnel', EntityType::class,['class'=>Personnel::class,'choice_label'=>'per_matricule'])
        
            
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateurs::class,
        ]);
    }
}
