<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Coordonnee;
use App\Repository\UsersRepository;
use App\Repository\CoordonneeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

final class AssuresController extends AbstractController
{
    #[Route('/login', name: 'app_assures_login')]
    public function index(UsersRepository $usersRepository): Response
    {
        // Récupérer tous les utilisateurs depuis la BD
        $users = $usersRepository->findAll();

        return $this->render('premier_symfony/login.html.twig', [
            'users' => $users,
        ]);
    }

    // Route pour la page du tableau de bord
    #[Route('/dashboard', name: 'dashBoard')]
    public function dashBord(CoordonneeRepository $coordonneeRepository, UsersRepository $usersRepository): Response
    {
        // Récupérer tous les assurés depuis la BD
        $assures = $coordonneeRepository->findAll();
        
        // Récupérer tous les utilisateurs depuis la BD
        $users = $usersRepository->findAll();

        return $this->render('premier_symfony/dashboard.html.twig', [
            'Assures' => $assures,
            'user' => $users,
        ]);
    }
}
