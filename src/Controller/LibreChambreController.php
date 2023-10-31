<?php

namespace App\Controller;
use App\Repository\ChambreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LibreChambreController extends AbstractController
{
    #[Route('/libre/chambre', name: 'app_libre_chambre')]

      public function index(ChambreRepository $chambreRepository): Response

   
    {

$chambresLibres = $chambreRepository->findEmptyRooms();
//  dd($chambresLibres);
$nbrChambre = count($chambresLibres);


//   $countChambre = $chambreRepository->findcountChambre();



        return $this->render('libre_chambre/index.html.twig', [
            'chambresLibres' => $chambresLibres,
            'nbrChmabres' => $nbrChambre,
            // 'countChambres' => $countChambre,
            
        ]);
    }
}