<?php

namespace App\Controller;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class AssuresController extends AbstractController
{
    #[Route('/login', name: 'app_assures_login')]
    public function index(): Response
{
    $users1 = new Users("J00567", "HedjaZaharir", "12345");
    $users2 = new Users("J00987", "SouffouDine", "09864");
    $users3 = new Users("J00453", "MohamedaAhmed", "56478");
    $users4 = new Users("J00637", "SouffouEchat", "25806");

    $LesUsers = [$users1, $users2, $users3, $users4];

    return $this->render('premier_symfony/login.html.twig', [
        'LesUsers' => $LesUsers,
    ]);
}

    // Route pour la page du tableau de bord
    #[Route('/dashboard', name: 'dashBoard')]
    public function dashBord(): Response
    {
       // return $this->render('dashboard/index.html.twig');
       return new Response();
    }       
}
