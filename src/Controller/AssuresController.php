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
    public function index(Request $request): Response
    {
        
        // Récupération des paramètres GET nom et prenom avec des valeurs par défaut
        $nom = "moussa";
        $prenom = "ali";
        $role = "admin";
       

        //Retourne une réponse 
         /*return $this->render('premier_symfony/index.html.twig', [
             'nom' => $nom,
             'prenom' => $prenom,                                                                                                                             
             'role' => $role
         ]); */

         return new Response();
    }

    // Route pour la page du tableau de bord
    #[Route('/dashboard', name: 'dashBoard')]
    public function dashBord(): Response
    {
       // return $this->render('dashboard/index.html.twig');
       return new Response();
    }       
}
