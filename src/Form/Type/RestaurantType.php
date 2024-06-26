<?php

namespace App\Form\Type;

use App\Entity\Categories;
use App\Entity\Restaurants;
use App\Form\FileTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RestaurantType extends AbstractType
{

    public function __construct(
        private readonly FileTransformer $fileTransformer
    )
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('shopUrl', TextType::class)
            ->add('fileName', FileType::class, [
                'label' => 'Image',

            ])
            ->add('description', TextareaType::class);

       $builder->get('fileName')->addModelTransformer($this->fileTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Restaurants::class
        ]);
    }
}