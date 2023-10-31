<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('email', EmailType::class, [
                'constraints' => [
                    new Email([
                        'message' => 'L\'adresse e-mail n\'est pas valide', // Message d'erreur en cas d'adresse e-mail invalide
                    ]),
                ],
            ])

            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped' => false,
 
 
                'required' => false, // afin eviter de demander le mot de passe dans le formulaire modifier le profil, bloque la soumission du mot de passe
 
                'attr' => ['autocomplete' => 'new-password'],// Attribut HTML pour l'autocomplétion du champ de mot de passe
                'constraints' => [
                    new Length([  // Vérifie la longueur du mot de passe
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins 6 caractères', //message erreur
 
                        // 'max' => 20,
    
                        'max' => 10,
 
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[A-Z])(?=.*\d)/',
                        'message' => 'Votre mot de passe doit contenir au moins une lettre majuscule et au moins un chiffre.',
                    ]),
                ],
            ])

            ->add('adresse')

            ->add('telephone', TextType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d+$/',
                        'message' => 'Le numéro de téléphone doit contenir uniquement des chiffres.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}