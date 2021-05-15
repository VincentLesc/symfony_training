<?php

namespace App\Form\Challenge;

use App\Entity\Challenge\Challenge;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use App\Entity\Challenge\ChallengeTranslation;
use App\Repository\Challenge\ChallengeTranslationRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;

class ChallengeTranslationType extends AbstractType
{
    /**
     * @var ChallengeTranslationRepository $repository
     */
    private $repository;

    public function __construct(ChallengeTranslationRepository $challengeTranslationRepository)
    {
        $this->repository = $challengeTranslationRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('rules')
            ->add('challenge')
        ;
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $entity = $event->getData();
            $form = $event->getForm();
            $form->add('locale', LocaleType::class, [
                'preferred_choices' => ['fr', 'en', 'es', 'it'],
                 'multiple' => false,
                 'data' => $entity->getLocale() ? $entity->getLocale() : $this->getAvailableLocales($entity->getChallenge())
            ]);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChallengeTranslation::class,
        ]);
    }

    private function getAvailableLocales(Challenge $challenge)
    {
        $localesRegistered = $this->repository->getLocalesByChallenge($challenge);
        $locales = array();
        foreach ($localesRegistered as $item) {
            $locales[] = $item['locale'];
        }
        $defaults = ['fr', 'en', 'es', 'it', 'de'];
        return array_diff($defaults, $locales)[0];
    }
}
