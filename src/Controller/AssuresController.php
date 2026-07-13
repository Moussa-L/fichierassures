<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\ChmListeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

// Contrôleur principal pour les pages d'authentification et de tableau de bord.
final class AssuresController extends AbstractController
{
    #[Route('/login', name: 'app_assures_login')]
    public function index(): Response
    {
        // Affiche la page de connexion.
        return $this->render('premier_symfony/login.html.twig', [
            //'LesUsers' => $LesUsers,
        ]);
    }

    // Route pour la page du tableau de bord
    #[Route('/dashboard', name: 'dashBoard')]
    public function dashBord(Request $request, ChmListeRepository $chmListeRepository): Response
    {
        // Lecture des filtres de recherche depuis la query string.
        $filters = [
            'nir' => $request->query->get('nir', ''),
            'macben' => $request->query->get('macben', ''),
            'nom' => $request->query->get('nom', ''),
            'prenom' => $request->query->get('prenom', ''),
            'dateNaissance' => $request->query->get('dateNaissance', ''),
            'dateTraitement' => $request->query->get('dateTraitement', ''),
            'nirBnf' => $request->query->get('nirBnf', ''),
        ];

        // Détermine si des filtres ont été fournis.
        $hasFilters = array_filter($filters);
        $results = $hasFilters 
            ? $chmListeRepository->searchAssures($filters)
            : $chmListeRepository->findAllForDashboard();

        // Ajoute des champs calculés pour l'affichage du tableau de bord.
        $assures = array_map(function (array $assure): array {
            $assure['lieuNaissance'] = '';
            $assure['adresseComplete'] = $this->formatAdresseComplete($assure);

            return $assure;
        }, $results);

        // Charge un fichier PHP externe contenant un utilisateur de test.
        require __DIR__ . '/UsersAssures.php';

        return $this->render('premier_symfony/dashboard.html.twig', [
            'Assures' => $assures,
            'user' => $users1,
        ]);
    }

    // Formate une adresse complète à partir des éléments d'adresse de l'assuré.
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
