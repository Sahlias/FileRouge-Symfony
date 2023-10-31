<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Validator\Constraints\Regex;


class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
 
            ->add('plainPassword', RepeatedType::class, [
 
                'type' => PasswordType::class,
                'options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                    ],
                ],
                'first_options' => [
                    'constraints' => [
                        new NotBlank([

                //             'message' => 'Please enter a password',
                //         ]),
                //         new Length([
                //             'min' => 6,
                //             'minMessage' => 'Your password should be at least {{ limit }} characters',
                //              max length allowed by Symfony for security reasons
                //             'max' => 4096,
                //         ]),
                //     ],
                //     'label' => 'New password',
                // ],
                // 'second_options' => [
                //     'label' => 'Repeat Password',
                // ],
                // 'invalid_message' => 'The password fields must match.',

                            'message' => 'Entrez un mot de passe',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} characters',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                        new Regex([
                            'pattern' => '/^(?=.*[A-Z])(?=.*\d)/',
                            'message' => 'Votre mot de passe doit contenir au moins une lettre majuscule et au moins un chiffre.',
                        ]),
                    ],
                    'label' => 'Nouveau mot de passe',
                ],
                'second_options' => [
                    'label' => 'Confirmer votre nouveau mot de passe',
                ],
                'invalid_message' => 'Mot de passe non identique',

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