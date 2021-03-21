<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class ChangePasswordFormType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => $this->translator->trans('reset_password.email_form.blank_message'),
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => $this->translator->trans('reset_password.password_form.password_lenght', ['%limit%' => 6]),
                            'max' => 4096,
                        ]),
                    ],
                    'label' => $this->translator->trans('reset_password.password_form.password_input_label'),
                    'attr' => [
                        'class' => 'form-control mb-2'
                    ],
                ],
                'second_options' => [
                    'label' => $this->translator->trans('reset_password.password_form.password_repeated_input_label'),
                    'attr' => [
                        'class' => 'form-control mb-2'
                    ],
                ],
                'invalid_message' => $this->translator->trans('reset_password.password_form.password_not_same'),
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
