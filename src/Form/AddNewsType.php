<?php

namespace App\Form;

use App\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddNewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   
    $builder
        ->add('name', TextType::class, [

            'required' => true,
            'constraints' => [new Length([
                'min' => 3,
                
            ]),

        ],
        ])
        ->add('description')
        ->add('content')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
