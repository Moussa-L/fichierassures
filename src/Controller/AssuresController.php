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
    // Point d'entrée principal du contrôleur d'authentification et du tableau de bord.
    #[Route('/login', name: 'app_assures_login', methods: ['GET', 'POST'])]
    public function index(Request $request, Connection $connection): Response
    {
        // Récupère la session HTTP pour vérifier si un utilisateur est déjà connecté.
        // La session stocke l'état de l'authentification entre les requêtes et permet de conserver l'utilisateur connecté d'une page à l'autre.
        $session = $request->getSession();

        // Si une session utilisateur existe, on redirige directement vers le tableau de bord.
        // Cela évite de demander une nouvelle connexion à un utilisateur déjà identifié et permet de conserver l'expérience utilisateur fluide.
        if ($session->has('user')) {
            return $this->redirectToRoute('dashBoard');
        }

        // Variable utilisée pour afficher un message d'erreur en cas d'échec de connexion.
        // Elle reste vide tant qu'aucune erreur n'est survenue, puis reçoit le texte d'erreur si la vérification échoue.
        $error = null;

        // Traitement du formulaire de connexion lorsqu'une requête POST est envoyée.
        if ($request->isMethod('POST')) {
            // Nettoie les valeurs saisies avant vérification.
            // trim() supprime les espaces en début et fin de chaîne afin d'éviter des erreurs de comparaison dues à une saisie mal formatée.
            $login = trim((string) $request->request->get('login', ''));
            $password = trim((string) $request->request->get('password', ''));

            // Vérifie l'existence de l'utilisateur dans la base de données via une requête directe.
            // La requête compare le login et le mot de passe fournis avec ceux enregistrés dans la table des utilisateurs.
            $user = $connection->fetchAssociative(
                'SELECT [login], [password], [Nom] FROM tab_users WHERE [login] = :login AND [password] = :password',
                [
                    'login' => $login,
                    'password' => $password,
                ]
            );

            // Si l'utilisateur est trouvé, on enregistre ses informations en session.
            // Les données stockées sont ensuite utilisées par les vues et les contrôleurs suivants pour personnaliser l'affichage et contrôler l'accès.
            if ($user) {
                $session->set('user', [
                    'login' => $user['login'],
                    'nom' => $user['Nom'],
                ]);

                return $this->redirectToRoute('dashBoard');
            }

            // Message affiché si les identifiants ne correspondent à aucun utilisateur.
            $error = 'Identifiants incorrects.';
        }

        // Affiche la vue de connexion avec un éventuel message d'erreur.
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
        // Bloque l'accès au tableau de bord si aucune session utilisateur n'est active.
        if (!$request->getSession()->has('user')) {
            return $this->redirectToRoute('app_assures_login');
        }

        // Collecte les filtres envoyés via la barre de recherche du tableau de bord.
        // Chaque clé correspond à un critère de recherche disponible dans l'interface, permettant d'affiner les résultats affichés.
        $filters = [
            'nir' => $request->query->get('nir', ''),
            'macben' => $request->query->get('macben', ''),
            'nom' => $request->query->get('nom', ''),
            'prenom' => $request->query->get('prenom', ''),
            'dateNaissance' => $request->query->get('dateNaissance', ''),
            'dateTraitement' => $request->query->get('dateTraitement', ''),
            'nirBnf' => $request->query->get('nirBnf', ''),
        ];

        // Détermine si au moins un filtre a été saisi par l'utilisateur.
        // array_filter supprime les valeurs vides afin d'identifier uniquement les critères réellement actifs.
        $hasFilters = array_filter($filters);
        // Exécute une recherche filtrée si des critères sont fournis, sinon charge tous les résultats.
        // Cette logique permet d'adapter la requête au contexte d'utilisation du tableau de bord.
        $results = $hasFilters
            ? $chmListeRepository->searchAssures($filters)
            : $chmListeRepository->findAllForDashboard();

        // Transforme les données récupérées pour les adapter à la vue du tableau de bord.
        // Cette étape complète les informations nécessaires à l'affichage en ajoutant des champs utiles à la vue.
        $assures = array_map(function (array $assure): array {
            $assure['lieuNaissance'] = '';
            $assure['adresseComplete'] = $this->formatAdresseComplete($assure);

            return $assure;
        }, $results);

        // Récupère les informations utilisateur depuis la session pour l'affichage.
        // Le nom et prénom sont ensuite transmis à la vue pour personnaliser l'interface.
        $user = $request->getSession()->get('user', []);

        // Envoie les données préparées vers le template du tableau de bord.
        // Les variables transmises à la vue sont utilisées par Twig pour construire la page HTML.
        return $this->render('premier_symfony/dashboard.html.twig', [
            'Assures' => $assures,
            'user' => [
                'nomPrenom' => $user['nom'] ?? $user['login'] ?? 'Utilisateur',
            ],
        ]);
    }

    private function formatAdresseComplete(array $assure): string
    {
        // Construit la partie voie de l'adresse à partir des informations disponibles.
        $voie = trim(implode(' ', array_filter([
            $assure['adresseType'] ?? null,
            $assure['adresseLibelle'] ?? null,
        ])));

        // Construit la partie ville et code postal de l'adresse.
        $ville = trim(implode(' ', array_filter([
            $assure['adresseCodePostal'] ?? null,
            $assure['adresseCommune'] ?? null,
        ])));

        // Assemble les éléments de l'adresse en une chaîne lisible pour la vue.
        return implode(', ', array_filter([
            $voie,
            $assure['adresseComplement'] ?? null,
            $ville,
        ]));
    }
}
