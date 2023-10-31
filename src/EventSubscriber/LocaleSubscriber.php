<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{

    // déclaration d'une propriété
    private $defaultLocale;

    //  parametre dans le constructeur $defaultLocale qui a comme valeur 'fr'
    public function __construct($defaultLocale = 'fr')
    {
        // initialisation de la propriété, on va lui donner une valeur qui est 'fr' 
        $this->defaultLocale = $defaultLocale;
    }



    public static function getSubscribedEvents()
    {   // Retourne un tableau indiquant l'événement à écouter lorsqu'il y en a un et la méthode à appeler pour cet événement
        return [

            // L'événement à écouter est KernelEvents::REQUEST
            // La méthode(function) à appeler est onKernelRequest, avec une priorité de 20 (ordre d'exécution parmi les événements)
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }



    // Méthode appelée lorsqu'un événement KernelEvents::REQUEST est déclenché
    public function onKernelRequest(RequestEvent $event): void
    {
        // recupérer la requete actuelle lors de l'évenement 
        // $request contient toutes les informations relatives à la requête HTTP en cours
        $request = $event->getRequest();

        // Si la locale est définie dans la session, utilisez-la, sinon utiliser la locale par défaut que l'on a précédément initialisé dans le constructeur avec comme valeur 'fr'
        $locale = $request->getSession()->get('_locale', $this->defaultLocale);
        
        // Définir la locale avec la variable $locale qui a comme valeur la nouvelle locale('fr' ou 'en') pour la requête actuelle
        $request->setLocale($locale);
    }


}
