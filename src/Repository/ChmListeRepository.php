<?php

namespace App\Repository;

use App\Entity\ChmListe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ChmListeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChmListe::class);
    }

    public function findByNir(string $nir): ?ChmListe
    {
        return $this->findOneBy(['assmacBen' => $nir]);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

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
                d.[CMMUNE_DRG] AS adresseCommune
            FROM [dbo].[chm_liste] l
            LEFT JOIN [dbo].[chm_drg] d ON d.[ASSAC_DRG] = l.[ASSMAC_BEN]
            ORDER BY l.[JODDSD_J] DESC
        SQL;

        return $this->getEntityManager()
            ->getConnection()
            ->executeQuery($sql)
            ->fetchAllAssociative();
    }
}
