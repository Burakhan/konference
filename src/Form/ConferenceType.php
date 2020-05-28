<?php

namespace App\Form;

use App\Constants\ConferenceTypeConstants;
use App\Entity\Conference;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description', TextAreaType::class)
            ->add('conference_type', ChoiceType::class, [
                'choices' => [
                  'İnternet Üzerinden' => ConferenceTypeConstants::ONLINE,
                  'Yüz Yüze' => ConferenceTypeConstants::FACETOFACE,
                  'Karma' => ConferenceTypeConstants::MIXED,
                ],
                'label' => false,
                'expanded' => true,
                'multiple' => false
            ])
            ->add('start_date')
        ->add('end_date')
        ->add('institution');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Conference::class,
        ]);
    }
}
