<?php

namespace App\Security;

use App\Entity\User;
use DateTime;
use League\OAuth2\Client\Provider\GoogleUser;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;



class GoogleAuthenticator extends OAuth2Authenticator
{
    private ClientRegistry $clientRegistry;
    private EntityManagerInterface $entityManager;
    private RouterInterface $router;



    public function __construct(ClientRegistry $clientRegistry, EntityManagerInterface $entityManager, RouterInterface $router)
    {
        $this->clientRegistry = $clientRegistry;
        $this->entityManager = $entityManager;
        $this->router = $router;
    }

    // Méthode pour déterminer si cet authenticateur doit être utilisé pour la requête actuelle.
    public function supports(Request $request): ?bool
    {
        // Continue uniquement si la ROUTE actuelle correspond à la ROUTE de vérification
        return $request->attributes->get('_route') === 'connect_google_check';
    }


    // Méthode pour effectuer l'authentification réelle.
    public function authenticate(Request $request): Passport
    {
        $client = $this->clientRegistry->getClient('google');

        // Appel à fetchAccessToken qui gère le rafraîchissement automatique si nécessaire
        $accessToken = $this->fetchAccessToken($client);

        return new SelfValidatingPassport(
            new UserBadge($accessToken->getToken(), function () use ($accessToken, $client) {
                /** @var GoogleUser $googleUser */
                $googleUser = $client->fetchUserFromToken($accessToken);

                // Valider et nettoyer l'e-mail
                $email = filter_var($googleUser->getEmail(), FILTER_VALIDATE_EMAIL);

                if (!$email) {
                    throw new AuthenticationException('E-mail invalide provenant de Google.');
                }

                // Ont-ils déjà connecté avec Google ? Facile !
                $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

                // L'utilisateur n'existe pas, le créer !
                if (!$existingUser) {
                    
                    $existingUser = new User();
                    $existingUser->setEmail($email);
                    $existingUser->setNom($googleUser->getLastName());
                    $existingUser->setPrenom($googleUser->getFirstName());
                    $existingUser->setAdresse('12 rue de l\'AFPA');
                    $existingUser->setTelephone('06.01.02.03.04.05');
                    $existingUser->setDateDeNaissance(new \DateTime());
                    
                    // Générer un mot de passe aléatoire
                    $randomPassword = bin2hex(random_bytes(12));
                    // hasher le mot de passe avec la fonction password_hash(parametre1 : mot de passe, parametre2: PASSWORD_BCRYPT)
                    $hashedPassword = password_hash($randomPassword, PASSWORD_BCRYPT);
                    // modification du mot de passe avec le nouveau mot de passe hasher
                    $existingUser->setPassword($hashedPassword);

                    $this->entityManager->persist($existingUser);
                    $this->entityManager->flush($existingUser);
                }

                return $existingUser;
            })
        );
    }

    // Méthode appelée en cas de succès de l'authentification.
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Changer "app_dashboard" par une route de votre application
        return new RedirectResponse($this->router->generate('home'));
    }

    // Méthode appelée en cas d'échec de l'authentification.
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        return new Response($message, Response::HTTP_FORBIDDEN);
    }
}
