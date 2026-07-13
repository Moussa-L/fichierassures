<?php

namespace App\Repository;

use App\Entity\ChmListe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

// Repository pour l'entité ChmListe.
// Contient des requêtes personnalisées pour le tableau de bord et la recherche.
class ChmListeRepository extends ServiceEntityRepository
{
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
        return parent::findAll();
    }

    // Récupère les données nécessaires pour le tableau de bord.
    public function findAllForDashboard(int $limit = 1000): array
    {
        $safeLimit = max(1, min(5000, $limit));
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

    // Recherche d'assurés avec filtres dynamiques pour le tableau de bord.
    public function searchAssures(array $filters, int $limit = 1000): array
    {
        $safeLimit = max(1, min(5000, $limit));
        $where = [];
        $params = [];

        if (!empty($filters['nir'])) {
            $where[] = 'l.[ASSMAC_BEN] LIKE ?';
            $params[] = '%' . $filters['nir'] . '%';
        }
        if (!empty($filters['macben'])) {
            $where[] = 'l.[MACBEN_BEN] LIKE ?';
            $params[] = '%' . $filters['macben'] . '%';
        }
        if (!empty($filters['nirBnf'])) {
            $where[] = 'l.[MACBEN_BEN] LIKE ?';
            $params[] = '%' . $filters['nirBnf'] . '%';
        }
        if (!empty($filters['nom'])) {
            $where[] = 'l.[NOMSTD_BEN] LIKE ?';
            $params[] = '%' . $filters['nom'] . '%';
        }
        if (!empty($filters['prenom'])) {
            $where[] = 'l.[NOMPRM_BEN] LIKE ?';
            $params[] = '%' . $filters['prenom'] . '%';
        }
        if (!empty($filters['dateNaissance'])) {
            $where[] = 'CONVERT(VARCHAR(10), l.[NAIDAT_B], 103) = ?';
            $params[] = $filters['dateNaissance'];
        }
        if (!empty($filters['dateTraitement'])) {
            $where[] = 'CONVERT(VARCHAR(10), l.[JODDSD_J], 103) = ?';
            $params[] = $filters['dateTraitement'];
        }

        $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

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
            {$whereClause}
            ORDER BY l.[JODDSD_J] DESC
        SQL;

        return $this->getEntityManager()
            ->getConnection()
            ->executeQuery($sql, $params)
            ->fetchAllAssociative();
    }
}
