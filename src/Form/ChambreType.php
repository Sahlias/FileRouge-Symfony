<?php

namespace App\Form;

use App\Entity\Chambre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChambreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tarif')
            ->add('superficie')
            ->add('vueSurMer')
            ->add('Chaine_a_laCarte')
            ->add('climatisation')
            ->add('television_a_ecranPlat')
            ->add('telephone')
            ->add('chainesSatellite')
            ->add('chainesDuCable')
            ->add('coffreFort')
            ->add('materielDeRepassage')
            ->add('wifiGratuit')
            ->add('etat')
            ->add('libelle')
            ->add('categorie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chambre::class,
        ]);
    }
}