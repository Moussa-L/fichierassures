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
    // Contrôleur principal des assurés.
    // Cette classe gère :
    // - l'affichage et la validation du formulaire de connexion,
    // - la déconnexion,
    // - la redirection de la page racine vers la bonne destination,
    // - l'accès au tableau de bord authentifié,
    // - une route de test pour le calcul NIR.
    // Les routes sont définies directement en attributs Symfony pour lier chaque méthode à son URL.
    #[Route('/login', name: 'app_assures_login', methods: ['GET', 'POST'])]
    public function index(Request $request, Connection $connection): Response
    {
        // Récupère la session HTTP pour vérifier si un utilisateur est déjà connecté.
        // La session permet de conserver l'état d'authentification entre les pages et les requêtes successives.
        $session = $request->getSession();

        // Si une session utilisateur est déjà active, la méthode ne réaffiche pas le formulaire de connexion.
        // Elle redirige immédiatement vers le tableau de bord pour éviter la double authentification.
        if ($session->has('user')) {
            return $this->redirectToRoute('dashboard');
        }

        // Prépare un message d'erreur vide, qui sera utilisé uniquement si l'utilisateur entre de mauvais identifiants.
        $error = null;

        // Détecte l'envoi du formulaire de connexion via la méthode POST.
        // C'est dans ce bloc que le login et le mot de passe saisis sont récupérés et vérifiés.
        if ($request->isMethod('POST')) {
            // Récupère les valeurs saisies par l'utilisateur depuis le corps de la requête.
            // trim() nettoie les espaces en début et en fin pour éviter les faux échecs de comparaison.
            $login = trim((string) $request->request->get('login', ''));
            $password = trim((string) $request->request->get('password', ''));

            // Exécute une requête SQL pour retrouver l'utilisateur correspondant aux identifiants fournis.
            // Le résultat est un tableau associatif contenant les champs demandés si l'utilisateur existe.
            $user = $connection->fetchAssociative(
                'SELECT [login], [password], [Nom] FROM tab_users WHERE [login] = :login AND [password] = :password',
                [
                    'login' => $login,
                    'password' => $password,
                ]
            );

            // Si l'utilisateur existe en base, on stocke les informations essentielles en session.
            // Ces données sont utilisées comme preuve d'authentification pour les prochaines actions.
            if ($user) {
                $session->set('user', [
                    'login' => $user['login'],
                    'nom' => $user['Nom'],
                ]);

                // Après une connexion valide, on renvoie l'utilisateur vers son espace privé.
                return $this->redirectToRoute('dashboard');
            }

            // Si aucun utilisateur n'est trouvé, on prépare un message d'erreur affiché au visiteur.
            $error = 'Identifiants incorrects.';
        }

        // Affiche le template de connexion.
        // La vue reçoit le message d'erreur s'il y en a un, sinon elle affiche le formulaire proprement.
        return $this->render('/login.html.twig', [
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_assures_logout')]
    public function logout(Request $request): Response
    {
        // Cette action détruit uniquement la clé 'user' de la session.
        // Elle ne détruit pas la session entière, mais elle invalide l'état de connexion.
        $request->getSession()->remove('user');

        // Après la déconnexion, l'utilisateur est renvoyé vers la page de connexion.
        return $this->redirectToRoute('app_assures_login');
    }

    #[Route('/', name: 'app_root', methods: ['GET'])]
    public function root(Request $request): Response
    {
        // La route racine redirige automatiquement selon l'état de session.
        // C'est un point d'entrée simple qui choisit la page adéquate sans afficher de contenu.
        if ($request->getSession()->has('user')) {
            return $this->redirectToRoute('dashboard');
        }

        return $this->redirectToRoute('app_assures_login');
    }

    #[Route('/calculnir', name: 'calculnir', methods: ['GET'])]
    public function calculNir(Request $request): Response
    {
        // Route accessible en GET.
        // Elle affiche le template dédié au calcul NIR.
        return $this->render('calculNir.html.twig');
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(Request $request, ChmListeRepository $chmListeRepository): Response
    {
        // Vérifie l'état de connexion avant d'exposer le tableau de bord.
        // Si l'utilisateur n'est pas connecté, il est renvoyé vers la page de login.
        if (!$request->getSession()->has('user')) {
            return $this->redirectToRoute('app_assures_login');
        }

        // Lit les paramètres de recherche dans la requête GET envoyée par le tableau de bord.
        // Ces filtres permettent de restreindre l'ensemble des assurés affichés.
        $filters = [
            'nir' => $request->query->get('nir', ''),
            'macben' => $request->query->get('macben', ''),
            'nom' => $request->query->get('nom', ''),
            'prenom' => $request->query->get('prenom', ''),
            'dateNaissance' => $request->query->get('dateNaissance', ''),
            'dateTraitement' => $request->query->get('dateTraitement', ''),
            'nirBnf' => $request->query->get('nirBnf', ''),
        ];

        // Vérifie si un ou plusieurs champs de filtre ont été renseignés.
        // Ce test permet de choisir entre une recherche ciblée ou un affichage de tous les enregistrements.
        $hasFilters = array_filter($filters);

        // Utilise le repository pour renvoyer soit les résultats filtrés, soit l'ensemble des données.
        // Cela limite la charge de la requête quand l'utilisateur cherche un cas précis.
        $results = $hasFilters
            ? $chmListeRepository->searchAssures($filters)
            : $chmListeRepository->findAllFordashboard();

        // Prépare les données à envoyer au template.
        // Pour chaque assuré récupéré, on ajoute des champs calculés utiles à l'affichage.
        $assures = array_map(function (array $assure): array {
            $assure['lieuNaissance'] = '';
            $assure['adresseComplete'] = $this->formatAdresseComplete($assure);

            return $assure;
        }, $results);

        // Récupère le nom de l'utilisateur connecté depuis la session.
        // Ce nom est ensuite transmis à la vue pour personnaliser le tableau de bord.
        $user = $request->getSession()->get('user', []);

        // Rend le template du tableau de bord avec les données d'assurés et le nom de l'utilisateur.
        return $this->render('/dashboard.html.twig', [
            'Assures' => $assures,
            'user' => [
                'nomPrenom' => $user['nom'] ?? $user['login'] ?? 'Utilisateur',
            ],
        ]);
    }

    private function formatAdresseComplete(array $assure): string
    {
        // Construit la partie voie de l'adresse à partir des informations disponibles.
        // Si le type et le libellé de l'adresse existent, ils sont assemblés proprement.
        $voie = trim(implode(' ', array_filter([
            $assure['adresseType'] ?? null,
            $assure['adresseLibelle'] ?? null,
        ])));

        // Construit la partie ville et code postal de l'adresse.
        // L'objectif est de former un bloc lisible pour l'utilisateur final.
        $ville = trim(implode(' ', array_filter([
            $assure['adresseCodePostal'] ?? null,
            $assure['adresseCommune'] ?? null,
        ])));

        // Assemble les différents éléments en une seule chaîne texte pour l'affichage.
        // Si un segment est manquant, array_filter le supprime pour éviter les virgules superflues.
        return implode(', ', array_filter([
            $voie,
            $assure['adresseComplement'] ?? null,
            $ville,
        ]));
    }
}
