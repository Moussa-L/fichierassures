<?php

namespace App\Controller;

use App\Repository\ChmListeRepository;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AssuresController extends AbstractController
{
    #[Route('/login', name: 'app_assures_login', methods: ['GET', 'POST'])]
    public function index(Request $request, Connection $connection): Response
    {
        $session = $request->getSession();

        if ($session->has('user')) {
            return $this->redirectToRoute('dashBoard');
        }

        $error = null;

        if ($request->isMethod('POST')) {
            $login = trim((string) $request->request->get('login', ''));
            $password = trim((string) $request->request->get('password', ''));

            $user = $connection->fetchAssociative(
                'SELECT [login], [password], [Nom] FROM tab_users WHERE [login] = :login AND [password] = :password',
                [
                    'login' => $login,
                    'password' => $password,
                ]
            );

            if ($user) {
                $session->set('user', [
                    'login' => $user['login'],
                    'nom' => $user['Nom'],
                ]);

                return $this->redirectToRoute('dashBoard');
            }

            $error = 'Identifiants incorrects.';
        }

        return $this->render('premier_symfony/login.html.twig', [
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_assures_logout')]
    public function logout(Request $request): Response
    {
        $request->getSession()->remove('user');

        return $this->redirectToRoute('app_assures_login');
    }

    #[Route('/dashboard', name: 'dashBoard')]
    public function dashBord(Request $request, ChmListeRepository $chmListeRepository): Response
    {
        if (!$request->getSession()->has('user')) {
            return $this->redirectToRoute('app_assures_login');
        }

        $filters = [
            'nir' => $request->query->get('nir', ''),
            'macben' => $request->query->get('macben', ''),
            'nom' => $request->query->get('nom', ''),
            'prenom' => $request->query->get('prenom', ''),
            'dateNaissance' => $request->query->get('dateNaissance', ''),
            'dateTraitement' => $request->query->get('dateTraitement', ''),
            'nirBnf' => $request->query->get('nirBnf', ''),
        ];

        $hasFilters = array_filter($filters);
        $results = $hasFilters
            ? $chmListeRepository->searchAssures($filters)
            : $chmListeRepository->findAllForDashboard();

        $assures = array_map(function (array $assure): array {
            $assure['lieuNaissance'] = '';
            $assure['adresseComplete'] = $this->formatAdresseComplete($assure);

            return $assure;
        }, $results);

        $user = $request->getSession()->get('user', []);

        return $this->render('premier_symfony/dashboard.html.twig', [
            'Assures' => $assures,
            'user' => [
                'nomPrenom' => $user['nom'] ?? $user['login'] ?? 'Utilisateur',
            ],
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
