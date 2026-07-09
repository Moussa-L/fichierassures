<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\ChmListeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

final class AssuresController extends AbstractController
{
    #[Route('/login', name: 'app_assures_login')]
    public function index(): Response
    {
        

        

        return $this->render('premier_symfony/login.html.twig', [
            
            //'LesUsers' => $LesUsers,
        ]);
    }

    // Route pour la page du tableau de bord
    #[Route('/dashboard', name: 'dashBoard')]
    public function dashBord(ChmListeRepository $chmListeRepository): Response
    {
        $assures = array_map(function (array $assure): array {
            $assure['lieuNaissance'] = '';
            $assure['adresseComplete'] = $this->formatAdresseComplete($assure);

            return $assure;
        }, $chmListeRepository->findAllForDashboard());

        require __DIR__ . '/UsersAssures.php';

        return $this->render('premier_symfony/dashboard.html.twig', [
            'Assures' => $assures,
            'user' => $users1,
        ]);
    }

    private function formatAdresseComplete(array $assure): string
    {
        $voie = trim(implode(' ', array_filter([
            $assure['adresseType'] ?? null,
            $assure['adresseLibelle'] ?? null,
        ])));

        $ville = trim(implode(' ', array_filter([
            $assure['adresseCodePostal'] ?? null,
            $assure['adresseCommune'] ?? null,
        ])));

        return implode(', ', array_filter([
            $voie,
            $assure['adresseComplement'] ?? null,
            $ville,
        ]));
    }
}
