<?php

namespace App\Form;

use App\Entity\Pets;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class PetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category',EntityType::class,array('class'=>'App\Entity\Category','choice_label'=>"cateName")
            )
            ->add('PetName',TextareaType::class)
            ->add('Age',TextType::class)
            ->add('Price',TextType::class)
            ->add('Sex',TextType::class)
            ->add('Image',FileType::class,[
                'label'=>'Image file',
                'mapped'=> false,
                'required'=>false,
                'constraints'=>[
                    new File ([
                        'maxSize'=> '1024k',
                        'mimeTypesMessage'=>'Please upload a valid image',
                    ])
                ]
            ])
            ->add('Category',EntityType::class,array('class'=>'App\Entity\Category','choice_label'=>'CateName'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pets::class,
        ]);
    }
}
