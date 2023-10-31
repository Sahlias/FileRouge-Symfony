<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservations')]
class ReservationCrudTestController extends AbstractController
{
    #[Route('/', name: 'app_reservation_crud_test_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation_crud_test/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }


    // AJOUTER UNE NOUVELLE RESERVATION
    #[Route('/new', name: 'app_reservation_crud_test_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_crud_test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation_crud_test/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }





    #[Route('/{id}', name: 'app_reservation_crud_test_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation_crud_test/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }




    // MODIFIER UNE RESERVATION
    #[Route('/{id}/edit', name: 'app_reservation_crud_test_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_crud_test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation_crud_test/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }




    // SUPPRIMER UNE RESERVATION
    #[Route('/{id}', name: 'app_reservation_crud_test_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->request->get('_token'))) {

            // Récupérer l'entité Chambre associée à la réservation
            $chambre = $reservation->getChambre();

            // à chaque suppression on va changer l'état de la chambre par le set
            $chambre->setEtat(true);


            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
