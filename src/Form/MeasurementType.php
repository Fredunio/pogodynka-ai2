<?php

namespace App\Form;

use App\Entity\Measurement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('temperature')
            ->add('date',
                null,
                [
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'js-datepicker',
                    ],
                ]
            )
            ->add('humidity')
            ->add('wind'
                , ChoiceType::class,
                [
                    'choices' => [
                        'Strong' => 'Strong',
                        'Moderate' => 'Moderate',
                        'Weak' => 'Weak',
                        'None' => 'None',

                    ],
                ]

            )
            ->add('location',
                null,
                [
                    'class' => 'App\Entity\Location',
                    'choice_label' => 'city',
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
        ]);
    }

}
