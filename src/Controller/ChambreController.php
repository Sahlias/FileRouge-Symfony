<?php

namespace App\Controller;


use App\Repository\CategorieRepository;
use App\Repository\ChambreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChambreController extends AbstractController
{
    #[Route('/deluxe', name: 'app_chambre_deluxe')]
    public function index(CategorieRepository $categorieRepository, ChambreRepository $chambreRepository): Response
    {


        /* FONCTION POUR AFFICHER LES IMAGES 
        _________________________________________________________________________________________________________________________*/


        // pour ouvrir le dossier image on spécifie d'abord son chemin
        $dossierImg = "../public/image";
       
        // on l'ouvre avec la fonction scandir(): scandir — Liste les fichiers et dossiers dans un dossier et l'affiche sous forme de tableau
        $contenuDossierImg = scandir($dossierImg);

        // creation d'un tableau vide pour stocker les images valides
        $images = [];

        // filtre
        foreach ($contenuDossierImg as $image) {

            if ($image !== '.' && $image !== '..') {

                // remplissage du tableau
                $images[] = $image;
            }
        }

        // On mélange les images pour avoir un résultat aléatoire
        shuffle($images);
        // dd($images);


        /* FONCTION POUR AFFICHER LES CHAMBRES LIBRE ET PAR CATEGORIE
        _________________________________________________________________________________________________________________________*/


        // recupérer l'id des chambres doubles supérieures pour afficher seulement les Chambres doubles superieures
        $libelle = 'Chambre double deluxe';
        $categorieId = $categorieRepository->findCategoryIdByLibelle($libelle);  // on recupere la fonction dans le repository


        // afficher seulement les chambres libres. True = libre
        $etat = true;
        $chambreLibre = $chambreRepository->afficherChambreLibre($etat);


        // afficher la catégorie de la chambre
        $categories = $categorieRepository->findAll();


        // filtrer et rechercher uniquement les chambre avec l'id de la catégorie chambre double supérieur et avec un état libre(true)
        $chambres = $chambreRepository->findBy([
            'categorie' => $categorieId,
            'etat' => $chambreLibre,
        ]);
 
// dd($chambres);
 
 
        return $this->render('chambre/chambreDeluxe.html.twig', [

            'categories' => $categories,
            'chambres' => $chambres,
            'images' => $images,

        ]);
    }



    #[Route('/junior', name: 'app_chambre_junior')]
    public function chambreJunior(CategorieRepository $categorieRepository, ChambreRepository $chambreRepository): Response
    {

    /* FONCTION POUR AFFICHER LES IMAGES 
        _________________________________________________________________________________________________________________________*/


        // pour ouvrir le dossier image on spécifie d'abord son chemin
        $dossierImg = "../public/image";

        // on l'ouvre avec la fonction scandir(): scandir — Liste les fichiers et dossiers dans un dossier et l'affiche sous forme de tableau
        $contenuDossierImg = scandir($dossierImg);

        // creation d'un tableau vide pour stocker les images valides
        $images = [];

        // filtre
        foreach ($contenuDossierImg as $image) {

            if ($image !== '.' && $image !== '..') {

                // remplissage du tableau
                $images[] = $image;
            }
        }

        // On mélange les images pour avoir un résultat aléatoire
        shuffle($images);
        // dd($images);



        /* FONCTION POUR AFFICHER LES CHAMBRES LIBRE ET PAR CATEGORIE
        _________________________________________________________________________________________________________________________*/


        // recupérer l'id des chambres doubles supérieures pour afficher seulement les Chambres doubles superieures
        $libelle = 'Suite Junior';
        $categorieId = $categorieRepository->findCategoryIdByLibelle($libelle);  // on recupere la fonction dans le repository


        // afficher seulement les chambres libres. True = libre
        $etat = true;
        $chambreLibre = $chambreRepository->afficherChambreLibre($etat);


        // afficher la catégorie de la chambre
        $categories = $categorieRepository->findAll();


        // filtrer et rechercher uniquement les chambre avec l'id de la catégorie chambre double supérieur et avec un état libre(true)
        $chambres = $chambreRepository->findBy([
            'categorie' => $categorieId,
            'etat' => $chambreLibre,
        ]);


        return $this->render('chambre/chambreJunior.html.twig', [

            'categories' => $categories,
            'chambres' => $chambres,
            'images' => $images,
            
        ]);
    }





    #[Route('/superieure', name: 'app_chambre_superieure')]
    public function chambreSuperieure(CategorieRepository $categorieRepository, ChambreRepository $chambreRepository ): Response
    {

        /* FONCTION POUR AFFICHER LES IMAGES 
        _________________________________________________________________________________________________________________________*/


        // pour ouvrir le dossier image on spécifie d'abord son chemin
        $dossierImg = "../public/image";

        // on l'ouvre avec la fonction scandir(): scandir — Liste les fichiers et dossiers dans un dossier et l'affiche sous forme de tableau
        $contenuDossierImg = scandir($dossierImg);

        // creation d'un tableau vide pour stocker les images valides
        $images = [];

        // filtre
        foreach ($contenuDossierImg as $image) {

            if ($image !== '.' && $image !== '..') {

                // remplissage du tableau
                $images[] = $image;
            }
        }

        // On mélange les images pour avoir un résultat aléatoire
        shuffle($images);
        // dd($images);



        /* FONCTION POUR AFFICHER LES CHAMBRES LIBRE ET PAR CATEGORIE
        _________________________________________________________________________________________________________________________*/


        // recupérer l'id des chambres doubles supérieures pour afficher seulement les Chambres doubles superieures
        $libelle = 'Chambre double superieure';
        $categorieId = $categorieRepository->findCategoryIdByLibelle($libelle);  // on recupere la fonction dans le repository


        // afficher seulement les chambres libres. True = libre
        $etat = true;
        $chambreLibre = $chambreRepository->afficherChambreLibre($etat);


        // afficher la catégorie de la chambre
        $categories = $categorieRepository->findAll();


        // filtrer et rechercher uniquement les chambre avec l'id de la catégorie chambre double supérieur et avec un état libre(true)
        $chambres = $chambreRepository->findBy([
            'categorie' => $categorieId,
            'etat' => $chambreLibre,
        ]);


        return $this->render('chambre/chambreSuperieure.html.twig', [

            'categories' => $categories,
            'chambres' => $chambres,
            'images' => $images,
            

        ]);
    }
}