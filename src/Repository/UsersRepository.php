<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    public function findByNumAgent(string $numAgent): ?Users
    {
        return $this->findOneBy(['numAgent' => $numAgent]);
    }

    public function findAll(): array
    {
        return $this->findAll();
    }
}
