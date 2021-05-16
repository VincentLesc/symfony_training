<?php

namespace App\Form\Challenge;

use App\Entity\Challenge\ChallengeParticipation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ChallengeParticipationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('imageFile', VichImageType::class, [
                'required' => true,
                'allow_delete' => true,
                'image_uri' => true,
                'asset_helper' => true,
            ]);
        if ($options['origin'] === 'admin') {
            $builder
            ->add('challenge')
            ->add('profile');
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChallengeParticipation::class,
            'origin' => 'front'
        ]);
    }
}
