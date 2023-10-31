<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
class ChiffreDaffairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       $builder

            ->add('DateEntree', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date d\'entrée',
            ])
            ->add('DateSortie', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de sortie',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null, // Laissez cette option à null pour que le formulaire n'ait pas besoin d'une classe de données spécifique
            'method' => 'POST',   // Méthode HTTP utilisée pour soumettre le formulaire
            'csrf_protection' => true, // Activez la protection CSRF pour sécuriser le formulaire (conseillé)
            'csrf_field_name' => '_token', // Nom du champ CSRF
            'csrf_token_id' => 'chiffre_daffaires_token', // ID du jeton CSRF
        ]);
    }
}