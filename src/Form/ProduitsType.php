<?php

namespace App\Form;

use App\Entity\Produits;
use App\Entity\Rubrique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pro_libelle')
            ->add('pro_description')
            ->add('pro_ref')
            ->add('pro_prix')
            ->add('pro_photo', FileType::class, [ //on indique que ce champ sera de type file
                'label' => 'Veuillez selectionner une photo'
            ])
            ->add('pro_stock')
            ->add('pro_stock_alert')
            ->add('Rubriques', EntityType::class,['class'=>Rubrique::class,'choice_label'=>'rub_libelle']) // ce champ sera un select des rubriques save dans la table rubrique
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
