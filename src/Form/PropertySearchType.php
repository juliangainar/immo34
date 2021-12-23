<?php

namespace App\Form;

use App\Entity\PropertySearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('maxPrice', IntegerType::class,[
                'required' => false,
                'label'=> false,
                'attr' => [
                    'placeholder' => 'Budget max'
                ]
            ])
            ->add('minSurface',IntegerType::class,[
                    'required' => false,
                    'label'=> false,
                    'attr' => [
                        'placeholder' => 'Surface minimale'
                        ],
                'constraints' => [
                    new Range(['min' => 10, 'max' => 400], "La valeur doit être comprise entre {{ min }} et {{ max }}.")
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method'=> 'get',
            'csrf_protection' => false
        ]);
    }

}