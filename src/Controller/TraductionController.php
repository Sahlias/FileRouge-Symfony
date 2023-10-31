<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TraductionController extends AbstractController
{
    #[Route('/traduction/{_locale}', name: 'app_traduction', methods:['GET','POST'])]
    public function changeLocale(Request $request, string $_locale): Response
    {
        // on va indiquer les langues que l'on va accepté pour la traduction
        $supportedLocales = ['fr', 'en'];

        /* si j'indique dans {_locale}, 'es' qui est la langue espagnole alors la requete me retournera
        une réponse au format JSON avec le message indiqué */
        if (!in_array($_locale, $supportedLocales)) {

            return new JsonResponse(array('message' => "langue non trouvé!"));

        }

        // Configuration de la nouvelle locale pour la session, on stocke la langue dans la session
        // En utilisant la session pour stocker la locale, on conserve la préférence de langue de l'utilisateur tout au long de sa session sur le site.
        // chaque changement de langue nécéssite une session propre 
        $request->getSession()->set('_locale', $_locale);


        // modification de la locale. La variable $_locale contient la nouvelle langue (ex: 'en' )
        $request->setLocale($_locale);

        
        // Récupérer le referer (c'est-à-dire la page où l'on est) ou utiliser une URL par défaut si elle n'est pas disponible
        $referer = $request->headers->get('referer') ?? $this->generateUrl('home');

        // Rediriger vers le référent ou une autre page
        return $this->redirect($referer);


        // redirection vers la page d'accueil avec affichage dans l'url le paramètre '_locale' avec la valeur provenant de la variable '$_locale'
        // return $this->redirectToRoute('home', ['_locale' => $_locale]);

    }

}
