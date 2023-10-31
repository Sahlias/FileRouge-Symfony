<?php

namespace App\Controller;


// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;
// use App\Repository\ReservationRepository;

// class ReservationController extends AbstractController
// {
//     private $reservationRepository;

//     public function __construct(ReservationRepository $reservationRepository)
//     {
//         $this->reservationRepository = $reservationRepository;
//     }

//     #[Route('/user/reservations', name: 'user_reservations')]
//     public function getUserReservations(): Response
//     {
//         // Récupérez l'utilisateur actuellement authentifié
//         $user = $this->getUser();

//         if (!$user) {
//             // Gérez le cas où l'utilisateur n'est pas authentifié
//             throw $this->createAccessDeniedException('Vous n\'êtes pas connecté.');
//         }

//         // Récupérez les réservations de l'utilisateur
//         $reservations = $this->reservationRepository->findBy(['user' => $user]);

//         return $this->render('reservation/index.html.twig', [
//             'user' => $user,
//             'reservations' => $reservations,
//         ]);
//     }
// }

use App\Entity\User;
use App\Entity\Reservation;
use App\Entity\chambre;
use App\Form\ReservationType;
use App\Repository\ChambreRepository;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservation')]
class ReservationController extends AbstractController
{


    #[Route('/chambres-libres', name: 'chambres_libres', methods: ['GET'])]
    public function afficherChambresLibres(ChambreRepository $chambreRepository): Response
    {
        // Utilisez le repository de l'entité Chambre pour récupérer les chambres libres
        $chambresLibres = $chambreRepository->findOneBySomeField();
        // $chambresLibres = count($chambresLibres);
        //dd($chambresLibres);

        return $this->render('reservation/chambres_libres.html.twig', [
            'chambres' => $chambresLibres,
        ]);
    }


    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        // Récupérez l'utilisateur connecté
        $user = $this->getUser();

        // Vérifiez si l'utilisateur est connecté$security
        if ($user instanceof User) {
            // Récupérez les réservations de l'utilisateur connecté
            $reservations = $reservationRepository->findBy(['user' => $user]);
        } else {
            // L'utilisateur n'est pas connecté, vous pouvez gérer ce cas comme vous le souhaitez
            $reservations = [];
        }


        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }


    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ChambreRepository $chambreRepository): Response
    {
        $reservation = new Reservation();
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();
        // Lier l'utilisateur connecté à la réservation
        $reservation->setUser($user);
        //les chambres libres
        $chambresLibres = $chambreRepository->findOneBySomeField();
        // dd($chambresLibres);


        // Vérifier si une chambre disponible a été trouvée
        if (count($chambresLibres) === 0) {
            $this->addFlash('error', 'Aucune chambre disponible n\'a été trouvée.');
            return $this->redirectToRoute('app_reservation_index');
        }
        //dd(count($chambresLibres));

        // Créer un formulaire avec les chambres disponibles
        $form = $this->createForm(ReservationType::class, $reservation, [
            'chambresLibres' => $chambresLibres,
            'nombreChambresLibres' => count($chambresLibres),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les chambres sélectionnées par l'utilisateur
            $chambresSelectionnees = $form->get('chambres')->getData();

            // Associer les chambres sélectionnées à la réservation
            foreach ($chambresSelectionnees as $chambreSelectionnee) {
                $reservation->addReservation($chambreSelectionnee);

                // Mettre à jour l'état de la chambre en la marquant comme "occupée" (false)
                $chambreSelectionnee->setEtat(false);
                $entityManager->persist($chambreSelectionnee);
            }


            //dd($chambreSelectionnee);

            $entityManager->persist($reservation);
            $entityManager->flush();

            // Afficher une page de confirmation
            return $this->render('reservation/confirmation.html.twig', [
                'reservation' => $reservation,
            ]);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->request->get('_token'))) {

            // Récupérez toutes les chambres associées à la réservation
            $chambresReservees = $reservation->getChambre();
            dump($chambresReservees);
            if (!empty($chambresReservees)) {
                foreach ($chambresReservees as $chambre) {
                    // Mettez à jour l'état de chaque chambre pour la marquer comme "disponible"
                    $chambre->setEtat(true);
                    $entityManager->persist($chambre);
                }
            }

            // Supprimez la réservation
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}


        // #[Route('', name: 'app_reservation_show', methods: ['GET'])]
        // public function show(Reservation $reservation): Response
    // {
        
        
        
        
        //     return $this->render('reservation/show.html.twig', [
            //         'reservation' => $reservation,
            //     ]);
            // }