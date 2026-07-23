<?php

namespace App\Repository;

use App\Entity\ChmListe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

// Repository pour l'entité ChmListe.
// Contient des requêtes personnalisées pour le tableau de bord et la recherche.
class ChmListeRepository extends ServiceEntityRepository
{
    // Initialise le repository avec l'entité ChmListe et le registre Doctrine.
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChmListe::class);
    }

    // Recherche un assuré par son NIR.
    public function findByNir(string $nir): ?ChmListe
    {
        return $this->findOneBy(['assmacBen' => $nir]);
    }

    // Récupère tous les enregistrements de la table chm_liste.
    public function findAll(): array
    {
        // Retourne tous les enregistrements de la table chm_liste via Doctrine.
        return parent::findAll();
    }

    // Récupère les données nécessaires pour le tableau de bord.
    public function findAllFordashboard(int $limit = 1000): array
    {
        // Limite le nombre de lignes retournées pour éviter une surcharge mémoire.
        // La valeur est bornée entre 1 et 5000 pour garder une exécution stable.
        $safeLimit = max(1, min(5000, $limit));
        // Requête SQL brute optimisée pour le tableau de bord.
        // Cette requête sélectionne les informations principales de l'assuré
        // depuis la table `chm_liste` et joint les informations d'adresse
        // depuis la table `chm_drg` si elles existent.
        // Le résultat est ensuite transformé en tableau associatif utilisé par la vue.
        // Les alias `l` et `d` permettent de référencer les deux tables
        // de manière concise dans la sélection et le JOIN.
        $sql = <<<SQL

            SELECT TOP {$safeLimit}
                l.[ASSMAC_BEN] AS nir,

                l.[MACBEN_BEN] AS nirBnf,

                l.[NOMSTD_BEN] AS nom,

                l.[NOMPRM_BEN] AS prenom,

                l.[NAIDAT_B] AS dateNaissance,

                l.[JODDSD_J] AS dateTraitement,

                d.[VOITYP_DRG] AS adresseType,

                d.[VOILIB_DRG] AS adresseLibelle,

                d.[CPL_DRG] AS adresseComplement,

                d.[CDPT_DRG] AS adresseCodePostal,

                d.[Cmmune_drg] AS adresseCommune

            FROM [dbo].[chm_liste] l

            LEFT JOIN [dbo].[chm_drg] d ON d.[ASSAC_DRG] = l.[ASSMAC_BEN]

            ORDER BY l.[JODDSD_J] DESC
        SQL;

        return $this->getEntityManager()
            ->getConnection()
            ->executeQuery($sql)
            ->fetchAllAssociative();
    }

    private function buildDateSearchCondition(string $value, string $column): array
    {
        $value = trim((string) $value);

        if ($value === '') {
            return ['', []];
        }

        $normalizedValue = str_replace('-', '/', $value);
        $normalizedValue = preg_replace('/\s+/', '', $normalizedValue);

        if (!preg_match('/^(\d{1,2})(?:\/(\d{1,2}))?(?:\/(\d{4}))?$/', $normalizedValue, $matches)) {
            return ['CONVERT(VARCHAR(10), ' . $column . ', 103) LIKE ?', ['%' . $normalizedValue . '%']];
        }

        $day = isset($matches[1]) ? (int) $matches[1] : null;
        $month = isset($matches[2]) ? (int) $matches[2] : null;
        $year = isset($matches[3]) ? (int) $matches[3] : null;

        if ($day !== null && $month !== null && $year !== null) {
            $pattern = sprintf('%02d/%02d/%04d', $day, $month, $year);
            return ['CONVERT(VARCHAR(10), ' . $column . ', 103) = ?', [$pattern]];
        }

        if ($day !== null && $month !== null) {
            $pattern = sprintf('%02d/%02d/%%', $day, $month);
            return ['CONVERT(VARCHAR(10), ' . $column . ', 103) LIKE ?', [$pattern]];
        }

        if ($day !== null) {
            $dayPattern = sprintf('%02d/%%', $day);
            $monthPattern = sprintf('%%/%02d/%%', $day);
            return ['(CONVERT(VARCHAR(10), ' . $column . ', 103) LIKE ? OR CONVERT(VARCHAR(10), ' . $column . ', 103) LIKE ?)', [$dayPattern, $monthPattern]];
        }

        if ($month !== null) {
            $monthPattern = sprintf('%%/%02d/%%', $month);
            return ['CONVERT(VARCHAR(10), ' . $column . ', 103) LIKE ?', [$monthPattern]];
        }

        if ($year !== null) {
            $yearPattern = sprintf('%%/%04d', $year);
            return ['CONVERT(VARCHAR(10), ' . $column . ', 103) LIKE ?', [$yearPattern]];
        }

        return ['CONVERT(VARCHAR(10), ' . $column . ', 103) LIKE ?', ['%' . $normalizedValue . '%']];
    }

    // Recherche d'assurés avec filtres dynamiques pour le tableau de bord.
    // Les clauses WHERE sont construites uniquement pour les filtres fournis.
    // Les critères sont appliqués seulement si les valeurs sont présentes.
    public function searchAssures(array $filters, int $limit = 1000): array
    {
        // Garantit une limite sûre afin d'éviter un traitement excessif des données.
        // Cette borne protège l'application contre des requêtes trop volumineuses.
        $safeLimit = max(1, min(5000, $limit));
        // Tableau des clauses WHERE à construire dynamiquement.
        $where = [];
        // Paramètres associés aux filtres de recherche.
        $params = [];

        // Ajoute un critère de recherche si le filtre NIR est renseigné.
        if (!empty($filters['nir'])) {
            $where[] = 'l.[ASSMAC_BEN] LIKE ?';
            $params[] = '%' . $filters['nir'] . '%';
        }
        // Ajoute un critère de recherche si le filtre MACBEN est renseigné.
        if (!empty($filters['macben'])) {
            $where[] = 'l.[MACBEN_BEN] LIKE ?';
            $params[] = '%' . $filters['macben'] . '%';
        }
        // Ajoute un critère de recherche si le filtre NIR bénéficiaire est renseigné.
        if (!empty($filters['nirBnf'])) {
            $where[] = 'l.[MACBEN_BEN] LIKE ?';
            $params[] = '%' . $filters['nirBnf'] . '%';
        }
        // Ajoute un critère de recherche si le filtre nom est renseigné.
        if (!empty($filters['nom'])) {
            $where[] = 'l.[NOMSTD_BEN] LIKE ?';
            $params[] = '%' . $filters['nom'] . '%';
        }
        // Ajoute un critère de recherche si le filtre prénom est renseigné.
        if (!empty($filters['prenom'])) {
            $where[] = 'l.[NOMPRM_BEN] LIKE ?';
            $params[] = '%' . $filters['prenom'] . '%';
        }
        // Ajoute un critère de recherche si la date de naissance est fournie.
        // La recherche accepte une saisie partielle comme 04 ou 04/05 pour retrouver les résultats attendus.
        if (!empty($filters['dateNaissance'])) {
            [$dateWhere, $dateParams] = $this->buildDateSearchCondition($filters['dateNaissance'], 'l.[NAIDAT_B]');
            if ($dateWhere !== '') {
                $where[] = $dateWhere;
                $params = array_merge($params, $dateParams);
            }
        }
        // Ajoute un critère de recherche si la date de traitement est fournie.
        // La recherche accepte également une saisie partielle pour ce champ.
        if (!empty($filters['dateTraitement'])) {
            [$dateWhere, $dateParams] = $this->buildDateSearchCondition($filters['dateTraitement'], 'l.[JODDSD_J]');
            if ($dateWhere !== '') {
                $where[] = $dateWhere;
                $params = array_merge($params, $dateParams);
            }
        }

        // Crée une clause WHERE sécurisée en fonction des paramètres disponibles.
        // Si aucun filtre n'est fourni, la requête s'exécute sans restriction supplémentaire.
        // Les filtres ajoutés sont combinés avec des AND afin de respecter tous les critères fournis.
        $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        $sql = <<<SQL
            -- Sélectionne un nombre limité de résultats
            -- Debut de la requête de sélection avec limitation de résultats
            SELECT TOP {$safeLimit}
                -- Colonne NIR de la liste des assurés
                l.[ASSMAC_BEN] AS nir,

                l.[MACBEN_BEN] AS nirBnf,
                -- Informations personnelles de l'assuré
                l.[NOMSTD_BEN] AS nom,
                
                l.[NOMPRM_BEN] AS prenom,
                l.[NAIDAT_B] AS dateNaissance,
                l.[JODDSD_J] AS dateTraitement,
                -- Informations d'adresse depuis la table dépendante
                d.[VOITYP_DRG] AS adresseType,
                d.[VOILIB_DRG] AS adresseLibelle,
                d.[CPL_DRG] AS adresseComplement,
                d.[CDPT_DRG] AS adresseCodePostal,
                d.[Cmmune_drg] AS adresseCommune
            -- Récupère les données depuis la table principale et joint la table d'adresses
            FROM [dbo].[chm_liste] l
            LEFT JOIN [dbo].[chm_drg] d ON d.[ASSAC_DRG] = l.[ASSMAC_BEN]
            -- Applique les filtres optionnels si des paramètres de recherche sont fournis
            {$whereClause}
            -- Trie les résultats par date de traitement en ordre décroissant
            ORDER BY l.[JODDSD_J] DESC
        SQL;

        // Exécute la requête SQL construite dynamiquement avec les paramètres fournis.
        // Le résultat est récupéré sous forme de tableau associatif prêt à être utilisé par le contrôleur.
        return $this->getEntityManager()
            ->getConnection()
            ->executeQuery($sql, $params)
            ->fetchAllAssociative();
    }
}
