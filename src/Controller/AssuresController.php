<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

final class AssuresController extends AbstractController
{
    #[Route('/login', name: 'app_assures_login')]
    public function index(): Response
    {
        

        

        return $this->render('premier_symfony/login.html.twig', [
            'LesUsers' => $LesUsers,
        ]);
    }

    // Route pour la page du tableau de bord
    #[Route('/dashboard', name: 'dashBoard')]
    public function dashBord(): Response
    {
        return $this->render('premier_symfony/dashboard.html.twig');
    }
}
