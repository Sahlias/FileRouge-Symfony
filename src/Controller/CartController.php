<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Repository\ChambreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Reservation;
use App\Form\ReservationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class CartController extends AbstractController
{

    #[Route('/cart', name: 'reservation', methods: ['GET', 'POST'])]
    public function index(Request $request, chambre $chambre, SessionInterface $session, ChambreRepository $chambreRepository, EntityManagerInterface $entityManager): Response
    {

        // recupération du panier, va contenir l'id de la chambre (exemple : 105)
        $panier = $session->get("panier", []);
        // dd($panier);

        // créer un autre panier ou on va insérer toutes les données de la chambre
        $dataPanier = [];

        // pour chaque élement du panier, $id va stocké en valeur cet élement (exemple: $id prendra la valeur de 105)
        foreach ($panier as $id) {

            // on va rechercher la chambre correspondante à l'id  dans l'entité 'chambre' avec comme parametre l'id 
            $chambre = $chambreRepository->find($id);

            // Ajout de la chambre et toutes ses infos au tableau $dataPanier
            $dataPanier[] = [

                "chambre" => $chambre,

            ];
        }


        // CREATION FOMULAIRE RESERVATION
        // Création d'une nouvelle reservation: cad on créer un objet à partir de la class Reservation qui est une entité
        $reservation = new Reservation();

        // crée un formulaire en utilisant la méthode createForm()
        $form = $this->createForm(ReservationFormType::class, $reservation);


        // à chaque réservation, la date du jour sera automatiquement enregistrée
        $reservation->setDateReservation(new \DateTime('now'));

        // recupération de la date de reservation pour afficher sur le twig
        $date = $reservation->getDateReservation();

        // extraire et gérer les données du formulaire à partir de la requête HTTP, les lier à l'objet $reservation
        $form->handleRequest($request);

        
        // Vérifie si le formulaire a été soumis et s'il est valide
        if ($form->isSubmitted() && $form->isValid()) {

            // Récupérez l'utilisateur actuellement connecté
            $user = $this->getUser();

            // Modification de la propriété userId de l'entité reservation, on ajoute l'id de l'user actuellement connecté
            $reservation->setUser($user);

            foreach ($panier as $id) {

                $chambre = $chambreRepository->find($id);

                // insertion de l'id de la chambre reservé dans l'entité reservation 
                $reservation->setChambre($chambre);

                $chambre->setEtat(false);
            }

            // Stocker l'ID de la chambre dans $chambreId pour le réutiliser dans la redirection, possibilité de récupérer l'id de la chambre grace à la variable $chambre = $chambreRepository->find($id) qui a été crééé au dessus;
            $chambreId = $chambre->getId();
            // dd($chambreId) //va afficher par exemple : 106;

            // Persistance de l'objet Comment si celui ci n'a pas de id, si id alors passer directement au flush
            $entityManager->persist($reservation);

            // Enregistrez la réservation dans la base de données
            $entityManager->flush();

            // efface le contenue du panier lors de la soumission du formulaire 
            $session->remove("panier");

            // Redirigez l'utilisateur vers la page de paiement avec en parametre l'id de la chambre
            return $this->redirectToRoute('app_paiement', ['id' => $chambreId]);
        }

        return $this->render('cart/index.html.twig', [
            "dataPanier" => $dataPanier,
            'form' => $form->createView(),
            'datereservation' => $date,
        ]);
    }






    // route qui permet d'ajouter un article par son id 
    #[Route('/reservation/{id}', name: 'cart_add', methods: ['GET'])]
    public function add(Chambre $chambre, SessionInterface $session): Response
    {

        //recupération de l'id par l'entité depuis la route, va afficher par exemple: 106
        $id = $chambre->getId();

        // récupérer le panier actuel
        // "panier" = nom que je donne à mon panier
        // [] = si mon panier n'existe pas alors j'initialise un tableau vide
        $panier = $session->get("panier", []);


        // le panier qui est un tableau va contenir l'id de la chambre
        $panier = [

            $id
        ];

        // sauvegarde du panier avec son id dans la session
        $session->set("panier", $panier);
         //dd($panier);

        return $this->redirectToRoute("reservation");
    }




    // route qui pemet de supprimer une reservation de son panier ( attention ne supprime pas la reservation en elle meme!)
    #[Route('/delete/{id}', name: 'reservation_delete')]
    public function delete(SessionInterface $session): Response
    {

        $session->remove("panier");

        // redirection vers la page panier 
        return $this->redirectToRoute("reservation");
    }
}