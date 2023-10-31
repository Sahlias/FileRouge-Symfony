<?php

namespace App\Controller\Admin;

use App\Entity\Chambre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
 
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
 
 

class ChambreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Chambre::class;
    }

  
public function configureFields(string $pageName): iterable
{
    return [
        IdField::new('id')->hideOnForm(),
        IntegerField::new('tarif', 'Tarif'),
        TextField::new('superficie', 'Superficie'),
        BooleanField::new('vueSurMer', 'Vue sur la mer'),
        BooleanField::new('Chaines_a_laCarte', 'Chaînes à la carte'), 
        BooleanField::new('climatisation', 'Climatisation'),
        BooleanField::new('television_a_ecranPlat', 'Télévision à écran plat'),
        BooleanField::new('telephone', 'Téléphone'),
        BooleanField::new('chainesSatellite', 'Chaînes satellite'),
        BooleanField::new('chainesDuCable', 'Chaînes du câble'),
        BooleanField::new('coffreFort', 'Coffre-fort'),
        BooleanField::new('materielDeRepassage', 'Matériel de repassage'),
        BooleanField::new('WiFiGratuit', 'Wi-Fi Gratuit'),
        BooleanField::new('etat', 'État'),
        TextField::new('libelle', 'Libellé'),
        AssociationField::new('categorie', 'Catégorie'), 
    ];
}

}
 
 
 