<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationFormType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control mb-2'
                ],
                'label' => $this->translator->trans('user_registration.registration_form.email'),
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => $this->translator->trans('user_registration.registration_form.agreeTerms_label'),
                'constraints' => [
                    new IsTrue([
                        'message' => $this->translator->trans('user_registration.registration_form.agreeTerms'),
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => $this->translator->trans('user_registration.registration_form.password'),
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('user_registration.registration_form.enter_password'),
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => $this->translator->trans('reset_password.password_form.password_lenght', ['%limit%' => 6]),
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control mb-2'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
