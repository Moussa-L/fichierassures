<?php

namespace App\Repository;

use App\Entity\Coordonnee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

// Repository pour l'entité Coordonnee.
// Définit des méthodes pour rechercher des coordonnées d'assurés.
class CoordonneeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coordonnee::class);
    }

    // Recherche une coordonnée par le NIR de l'assuré.
    public function findByNir(string $nir): ?Coordonnee
    {
        return $this->findOneBy(['nirAss' => $nir]);
    }

    // Récupère toutes les coordonnées.
    public function findAll(): array
    {
        return parent::findAll();
    }
}
