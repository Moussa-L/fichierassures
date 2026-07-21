<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

// Repository pour l'entité Users.
// Fournit des méthodes dédiées pour récupérer les utilisateurs.
class UsersRepository extends ServiceEntityRepository
{
    // Initialise le repository d'utilisateurs pour l'accès aux données.
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    // Initialise le repository Users avec le registry Doctrine.
    // Ce constructeur configure l'accès à la table associée à l'entité.

    // Recherche un utilisateur par son numéro d'agent.
    // Le numéro d'agent est utilisé comme clé de recherche principale pour identifier un compte utilisateur.
    public function findByNumAgent(string $numAgent): ?Users
    {
        return $this->findOneBy(['numAgent' => $numAgent]);
    }

    // Récupère tous les utilisateurs.
    // Cette méthode permet de lister l'ensemble des comptes utilisateur.
    public function findAll(): array
    {
        return parent::findAll();
    }
}
