<?php

namespace App\Repository;

use App\Entity\ChmDrg;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

// Repository pour l'entité ChmDrg.
// Gère les adresses des assurés et les opérations de recherche associées.
class ChmDrgRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChmDrg::class);
    }

    // Recherche une adresse par le code ASSAC.
    public function findByAssac(string $assac): ?ChmDrg
    {
        return $this->findOneBy(['assacDrg' => $assac]);
    }

    // Récupère toutes les adresses.
    public function findAll(): array
    {
        return parent::findAll();
    }

    // Récupérer toutes les adresses avec une requête DQL.
    public function findAllWithAssures()
    {
        return $this->createQueryBuilder('d')
            ->getQuery()
            ->getResult();
    }
}
