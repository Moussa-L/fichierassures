<?php

namespace App\Repository;

use App\Entity\ChmDrg;
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

    public function findAllForDashboard(): array
    {
        return $this->createQueryBuilder('l')
            ->select([
                'l.assmacBen AS nir',
                'l.macbenBen AS nirBnf',
                'l.nomstdBen AS nom',
                'l.nomprmBen AS prenom',
                'l.naidatB AS dateNaissance',
                'l.joddsdJ AS dateTraitement',
                'd.voitypDrg AS adresseType',
                'd.voilibDrg AS adresseLibelle',
                'd.cplDrg AS adresseComplement',
                'd.cdptDrg AS adresseCodePostal',
                'd.cmmuneDrg AS adresseCommune',
            ])
            ->leftJoin(ChmDrg::class, 'd', 'WITH', 'd.assacDrg = l.assmacBen')
            ->orderBy('l.joddsdJ', 'DESC')
            ->getQuery()
            ->getArrayResult();
    }
}
