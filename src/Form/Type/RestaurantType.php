<?php

use Symfony\Component\Form\AbstractType;

class RestaurantType extends AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('categories', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class,[
                'class' => \App\Entity\Categories::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('shopUrl', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('description', \Symfony\Component\Form\Extension\Core\Type\TextareaType::class)
            ;
    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => \App\Entity\Restaurants::class
        ]);
    }
}