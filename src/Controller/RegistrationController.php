<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {

        // crée un nouvel utilisateur de l'entité User
        $user = new User();

        // creation du formulaire avec la class 'RegistrationFormType'
        // Le deuxième argument '$user' indique que le formulaire sera lié à l'objet '$user', ce qui signifie que les données saisies dans le formulaire seront associées à cet user.
        $form = $this->createForm(RegistrationFormType::class, $user);

        // extraire et gérer les données du formulaire à partir de la requête HTTP, les lier à l'objet $user
        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et s'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            // Persistance de l'objet $user si celui ci n'a pas de id, si id alors passer directement au flush
            $entityManager->persist($user);

            // Applique les modifications dans la base de données
            $entityManager->flush($user);

            // Redirige vers une autre page après l'inscription, soit la page connexion
            return $this->redirectToRoute('app_login');
        }


        // renvoie du formulaire vers la vue 
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
