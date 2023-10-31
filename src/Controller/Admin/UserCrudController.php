<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {

     return [
        IdField::new('id')->hideOnForm(),
        TextField::new('nom'),
        TextField::new('prenom'),
        TextField::new('adresse'),
        TextField::new('telephone'),
        DateField::new('date_de_naissance'),
        TextField::new('email'),
        AssociationField::new('user') // Utilisez le nom correct de la propriété
        ->setLabel('nombre de réservation') // Facultatif : définissez un label personnalisé
        ->onlyOnIndex(), // Afficher ce champ uniquement dans la liste des utilisateurs (index)
    
        TextField::new ('plainPassword')
          ->setLabel('Password')  

          
        
     ];
        

  
        
    }


      
  
}
    
    