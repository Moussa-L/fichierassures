<?php

namespace App\Repository;

use App\Entity\Coordonnee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CoordonneeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coordonnee::class);
    }

    public function findByNir(string $nir): ?Coordonnee
    {
        return $this->findOneBy(['nirAss' => $nir]);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }
}
