<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PdfGeneratorController extends AbstractController
{
    #[Route('/pdf/generator', name: 'app_pdf_generator', methods: ['GET'] )]
    public function index(SessionInterface $session): Response
    {

        // récupérer la session avec la réservation intégrer dans un tableau
        $reservation = $session->get("reservation");

        // Afficher le contenu de la réservation
        // dd est une fonction de Symfony utilisée pour déboguer et afficher le contenu d'une variable
        // dd($reservation);

        // calcul du nombre de jours entre la date entrée et la date de sortie pour multiplier par le tarif et afficher le montant total sur le twig
        // recupération des valeurs pour chaque propri
        $dateEntree = $reservation[0]->getDateEntree();
        $dateSortie = $reservation[0]->getDateSortie();

        // Récupérer le tarif de la chambre
        $tarifChambre = $reservation[0]->getChambre()->getTarif();

        // Calculer la différence entre les deux dates
        $difference = $dateSortie->diff($dateEntree);

        // Récupérer le nombre de jours
        $nbJours = $difference->days;

        // Calculer le montant total, on calcul directement dans le controleur, possibilité de calculer directement sur le twig
        $montantTotal = $nbJours * $tarifChambre;

        // on va afficher les infos dans le twig , le render va etre stocké dans une variable 
        $contenuPDF =  $this->renderView('pdf_generator/index.html.twig', [

            'reservations' => $reservation,
            'imageSrc'  => $this->imageToBase64($this->getParameter('kernel.project_dir') . '/public/img/VCH-removebg-preview_1.png'),
            'montantTotal' => $montantTotal,

        ]);


        // Créer une instance de Dompdf (créer un objet PDF)
        $dompdf = new Dompdf();

        // Charger le HTML (le contenu dans le twig) dans Dompdf, on récupère la variable $html
        $dompdf->loadHtml($contenuPDF);

        // Générer le PDF
        $dompdf->render();

        // Retourner la réponse PDF
        return new Response(
            $dompdf->stream('resume', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }

    private function imageToBase64($path)
    {
        $path = $path;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $img = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
        return $base64;
    }
}
