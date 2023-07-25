<?php

namespace App\Form;

use App\Entity\Restaurant;
use App\Entity\Ville;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,array(
                'label'=> 'Nom',
                'attr' => array(
                    'class' => 'form-control mb-3'
                )
            ))
            ->add('description', TextareaType::class, array(
                'label'=> 'Description',
                'attr' => array('class' => 'form-control mb-3'),
            ))
            // ->add('createdAt')
            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            // ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }
}
