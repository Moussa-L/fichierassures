<?php

namespace App\Repository;

use App\Entity\ChmDrg;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

// Repository pour l'entité ChmDrg.
// Gère les adresses des assurés et les opérations de recherche associées.
class ChmDrgRepository extends ServiceEntityRepository
{
    // Initialise le repository dédié aux adresses des assurés.
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChmDrg::class);
    }

    // Initialise le repository ChmDrg avec le registry Doctrine.
    // Ce repository gère l'accès aux enregistrements d'adresses.

    // Recherche une adresse par le code ASSAC.
    // Le code ASSAC est utilisé comme identifiant principal de l'adresse de l'assuré.
    public function findByAssac(string $assac): ?ChmDrg
    {
        return $this->findOneBy(['assacDrg' => $assac]);
    }

    // Récupère toutes les adresses.
    // Cette méthode retourne la liste complète des adresses disponibles.
    public function findAll(): array
    {
        return parent::findAll();
    }

    // Récupère toutes les adresses avec une requête DQL.
    // Cette méthode peut être utilisée pour charger des résultats avec des relations Doctrine.
    // Elle permet de travailler avec des objets Doctrine au lieu d'un simple tableau de résultats.
    public function findAllWithAssures()
    {
        return $this->createQueryBuilder('d')
            ->getQuery()
            ->getResult();
    }
}
