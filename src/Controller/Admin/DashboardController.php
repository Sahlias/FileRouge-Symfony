<?php

# composer require easycorp/easyadmin-bundle
# symfony console make:admin:dashboard
namespace App\Controller\Admin;
use App\Entity\Chambre;
use App\Entity\Reservation;
use App\Entity\User;
use App\Entity\Categorie;


use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin/dashboard', name: 'admin')]
    public function index(): Response
    {


        

        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
        ->renderContentMaximized()   
            ->setTitle('TP FIL ROUGE');
    }
public function configureCrud(): Crud
    {
        return Crud::new()
            ->renderContentMaximized()//ca c'est pour prendre tout l'espace du trvail
            ->showEntityActionsInlined();//ca c'est pour afficher supprimer et editer dans tout les crud
    }


    

#symfony console make:admin:crud de toutes les entity
public function configureMenuItems(): iterable
    {
        
        
           yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
           yield MenuItem::linkToCrud('Reservation', 'far fa-calendar',  Reservation::class);
           yield MenuItem::linkToCrud('Chambre', 'fa fa-bed',  Chambre::class);
           yield MenuItem::linkToCrud('Categorie', 'fa fa-grip-vertical',  Categorie::class);
           yield MenuItem::linkToCrud('Utilisateurs', 'far fa-user',  User::class);
 

        // //menu pour chiffre d'affaire
 

 

         yield MenuItem::section('Statistiques');
         yield MenuItem::linkToRoute('Chambres Occupées', 'fa fa-bed', 'chambreOcuppee');
        //  yield MenuItem::linkToRoute('Nombre de réservation', 'fa-solid fa-calendar-check',  'app_count_reservation');
         yield MenuItem::linkToRoute('Chiffre d\'affaires', 'fas fa-money-bill', 'app_chiffre_daffaires');
         
    }
} 