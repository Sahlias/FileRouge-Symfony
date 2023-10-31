<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Form\ChiffreDaffairesType;
use App\Repository\ChambreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChiffreDaffairesController extends AbstractController
{
    #[Route('/chiffre/daffaires', name: 'app_chiffre_daffaires')]
    public function index(Request $request, ChambreRepository $chambreRepository): Response
    {

        // Créez le formulaire 
        $form = $this->createForm(ChiffreDaffairesType::class);

        // Gérez la soumission du formulaire
        $form->handleRequest($request);


       
         $chiffreDaffaireForMonths = null;

      

        if ($form->isSubmitted() && $form->isValid()) {
            //récupérées les dates à partir du formulaire
            $startDate = $form->get('DateEntree')->getData();
            $endDate = $form->get('DateSortie')->getData();


            $chiffreDaffaireForMonths = $chambreRepository->calculateChiffreDaffairesByMonth($startDate, $endDate);   

            //dd($chiffreDaffaireForMonths);
        }
        
        
        return $this->render('chiffre_daffaires/index.html.twig', [
            'form' => $form->createView(), 
           
            'chiffreDaffaireForMonths' => $chiffreDaffaireForMonths,  
              ]);
 
        
        //     'chiffreDaffaireForMonths' => $chiffreDaffaireForMonths,
        // ]);
 
    }

}