<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ConfirmationController extends AbstractController
{
    #[Route('/confirmation', name: 'app_confirmation', methods: ['GET', 'POST'])]
    public function index(SessionInterface $session): Response
    {

        // récupérer la session avec la réservation intégrer dans un tableau
        $reservation = $session->get("reservation");
        // dd($reservation);

        // utilisation de cette méthode pour récupérer l'id si on ne veut pas utiliser la boucle for
        // récupération de l'id dans le tableau 
        $reservationId = $reservation[0]->getId();


        return $this->render('confirmation/index.html.twig', [

            // 'reservations' => $reservation, // utilisation de cette variable si on souhaite utiliser la boucle for
            'id_reservation' => $reservationId,

        ]);
    }
}
