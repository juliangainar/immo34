<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/security', name: 'security')]
    public function index(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils){
        // recupere les erreurs afin de les afficher
        $error = $authenticationUtils->getLastAuthenticationError();
        // recupere le dernier username utilisé
        $lastUsername = $authenticationUtils->getLastUsername();
        // retourne la vue et en parametres : les erreurs et le dernier username
        return $this->render('security/login.html.twig', [
            'last_username'=> $lastUsername,
            'error' => $error
        ]);
    }
}
