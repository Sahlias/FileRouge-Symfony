<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CountReservationController extends AbstractController
{
    #[Route('/count/reservation', name: 'app_count_reservation')]
    public function index(ReservationRepository $ReservationRepository): Response
    {


  $countReservation = $ReservationRepository->findcountReservation();

  return $this->render('count_reservation/index.html.twig', [
      'countReservation' => $countReservation,
    ]);
}
}