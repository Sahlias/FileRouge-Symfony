<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }
public function configureFields(string $pageName): iterable
{
    $currentDate = (new \DateTime())->format('Y-m-d');

    return [
        IdField::new('id')->hideOnForm(),
        Field::new('DateReservation')
            ->setFormType(DateType::class)
            ->setFormTypeOptions([
                'widget' => 'single_text',
                'html5' => true,
                'attr' => [
                    'min' => $currentDate,
                ],
            ])
            ->addCssClass('datepicker'),
        Field::new('DateEntree')
            ->setFormType(DateType::class)
            ->setFormTypeOptions([
                'widget' => 'single_text',
                'html5' => true,
                'attr' => [
                    'min' => $currentDate,
                ],
            ])
            ->addCssClass('datepicker'),
            Field::new('DateSortie')
            ->setFormType(DateType::class)
            ->setFormTypeOptions([
                'widget' => 'single_text',
                'html5' => true,
                'attr' => [
                    'min' => $currentDate,
                ],
            ])
            ->addCssClass('datepicker'),
        AssociationField::new('user'),
        AssociationField::new('chambre'),
    ];
}

}