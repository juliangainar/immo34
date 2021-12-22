<?php

namespace App\Form;

use App\Entity\Property;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextareaType::class, [
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'max' => 255,
                        'minMessage' => 'Le bien doit avoir au moins 10 carateres dans son nom.'

                    ])
                ]
            ])
            ->add('description')
            ->add('surface', NumberType::class, [
                'constraints' => [
                    new Range(['min' => 10, 'max' => 400], "La valeur doit être comprise entre {{ min }} et {{ max }}.")
                ],])
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('heat', ChoiceType::class, [
                'choices' => array_flip(Property::HEAT)
    ])
            ->add('city')
            ->add('adress')
            ->add('postal_code', NumberType::class,[
                'constraints' => [
                    new Regex("/^[0-9]{5}$/")]]
                )
            ->add('sold');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms'
        ]);
    }
}
