<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class AssuresController extends AbstractController
{
    
     // Route pour la page de login
    #[Route('/login', name: 'app_assures_login')]
    public function index(): Response
    {
        $titre = "Connexion";
       
        return $this->render('login.html.twig', [
             'titre' => $titre
         ]);
    }

    // Route pour la page du tableau de bord
    #[Route('/dashboard', name: 'dashBoard')]
    public function dashBord(): Response
    {
        $nom = "moussa";
        $prenom = "ali";
        $role = "admin";
       
        return $this->render('premier_symfony/dashboard.html.twig', [
             'nom' => $nom,
             'prenom' => $prenom,                                                                                                                             
             'role' => $role
         ]);
    }       
}

