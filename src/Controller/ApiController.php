<?php

namespace App\Controller;

use App\Repository\ChambreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api')]
    public function index(Request $request, ChambreRepository $chambreRepository): JsonResponse
    {
        //  récupérer les données du formulaire
        $startDate = $request->request->get('DateEntree');
        $endDate = $request->request->get('DateSortie');
        //les valeuurs prés à étre utiliser
         $startDate = new DateTime($request->request->get('DateEntree'));
         $endDate = new DateTime($request->request->get('DateSortie'));
         //ma requete dans chambreRepository
        $chiffreDaffaireForMonths = $chambreRepository->calculateChiffreDaffairesByMonth($startDate, $endDate);

        //retourner ma response
        return $this->json([
            'message' => 'Données reçues avec succès',
            'chiffreDaffaire' => $chiffreDaffaireForMonths, 
        ]);
    }
}