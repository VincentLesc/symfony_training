<?php

namespace App\Form\Challenge;

use App\Entity\Challenge\Challenge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChallengeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('displayAt')
            ->add('hideAt')
            ->add('participationStartsAt')
            ->add('participationEndsAt')
            ->add('voteBeginsAt')
            ->add('voteEndsAt')
            ->add('deliberationAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Challenge::class,
        ]);
    }
}
