<?php

namespace App\Controller;

use App\Entity\ChmDrg;
use App\Entity\Users;
use App\Repository\ChmDrgRepository;
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
    public function dashBord(ChmListeRepository $chmListeRepository, ChmDrgRepository $chmDrgRepository): Response
    {
        $assures = array_map(function ($assure) use ($chmDrgRepository): array {
            $adresse = $chmDrgRepository->findByAssac($assure->getAssmacBen());

            return [
                'nir' => $assure->getAssmacBen(),
                'nirBnf' => $assure->getMacbenBen(),
                'nom' => $assure->getNomstdBen(),
                'prenom' => $assure->getNomprmBen(),
                'dateNaissance' => $assure->getNaidatB(),
                'lieuNaissance' => '',
                'adresseComplete' => $this->formatAdresseComplete($adresse),
                'dateTraitement' => $assure->getJoddsdJ(),
            ];
        }, $chmListeRepository->findAll());

        require __DIR__ . '/UsersAssures.php';

        return $this->render('premier_symfony/dashboard.html.twig', [
            'Assures' => $assures,
            'user' => $users1,
        ]);
    }

    private function formatAdresseComplete(?ChmDrg $adresse): string
    {
        if (!$adresse) {
            return '';
        }

        $voie = trim(implode(' ', array_filter([
            $adresse->getVoitypDrg(),
            $adresse->getVoilibDrg(),
        ])));

        $ville = trim(implode(' ', array_filter([
            $adresse->getCdptDrg(),
            $adresse->getCmmuneDrg(),
        ])));

        return implode(', ', array_filter([
            $voie,
            $adresse->getCplDrg(),
            $ville,
        ]));
    }
}
