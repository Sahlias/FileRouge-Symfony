<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;

use Symfony\Component\Validator\Constraints\NotBlank;


use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Validator\Constraints\Regex;



class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

         // Crée le formulaire
        $builder

        ->add('nom', TextType::class, [
            'constraints' => [
                new Length([
                    'min' => 1,
                    'minMessage' => 'Le nom doit avoir au moins {{ limit }} caractères.',
                ]),
            ],
        ])

        ->add('prenom', TextType::class, [
            'constraints' => [
                new Length([
                    'min' => 1,
                    'minMessage' => 'Le prenom doit avoir au moins {{ limit }} caractères.',
                ]),
            ],
        ])

            // ->add('date_de_naissance', DateType::class, [

            ->add('date_de_naissance', null, [

                'widget' => 'single_text',
                'invalid_message' => 'Veuillez indiquer votre date de naissance',
                
            ])

            ->add('email', EmailType::class, [
                'constraints' => [
                    new Email([
                        'message' => 'L\'adresse e-mail n\'est pas valide', // Message d'erreur en cas d'adresse e-mail invalide
                    ]),
                ],
            ])

            ->add('adresse', TextType::class, [
                'constraints' => [
                    
                ],
            ])

            ->add('telephone', TextType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d+$/',
                        'message' => 'Le numéro de téléphone doit contenir uniquement des chiffres.',
                    ]),
                ],
            ])


            ->add('Conditions', CheckboxType::class, [ // Ajoute un champ de type case à cocher nommé 'conditions '
                'mapped' => false, // Ne mappe pas ce champ directement à une propriété de l'entité User
                'constraints' => [ // Ajoute des contraintes de validation
                    new IsTrue([  // Vérifie si la case à cocher est cochée
                        'message' => 'Vous devez accepter nos conditions d\'utilisation', // Message d'erreur en cas d'échec
                    ]),
                ],

                'label' => 'En créeant un compte vous acceptez nos conditions générales de vente', // Ajoutez cette ligne pour définir un label personnalisé
            ])


            // ->add('plainPassword', PasswordType::class, [ // Ajoute un champ de type mot de passe nommé 'password'=======
            ->add('password', PasswordType::class, [ // Ajoute un champ de type mot de passe nommé 'password'

                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],// Attribut HTML pour l'autocomplétion du champ de mot de passe
                'constraints' => [
                    new Length([  // Vérifie la longueur du mot de passe
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins 6 caractères', //message erreur
                        'max' => 10,
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[A-Z])(?=.*\d)/',
                        'message' => 'Votre mot de passe doit contenir au moins une lettre majuscule et au moins un chiffre.',
                    ]),
                ]

            ]);

    }

    
    //  configure les options du formulaire : lorsque le formulaire est soumis, Symfony créera un nouvel objet User et y attribuera les données saisies dans le formulaire.
    public function configureOptions(OptionsResolver $resolver): void
    {
        // définir les options par défaut pour ce formulaire en passant un tableau d'options à la méthode setDefaults de l'objet $resolver.
        $resolver->setDefaults([

            // Spécifie que les données du formulaire seront liées à la classe User
            // Cette option spécifie quelle classe sera utilisée pour créer un objet à partir des données du formulaire.
            'data_class' => User::class, 
        ]);
    }
}