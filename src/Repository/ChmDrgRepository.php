<?php

namespace App\Repository;

use App\Entity\ChmDrg;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ChmDrgRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChmDrg::class);
    }

    public function findByAssac(string $assac): ?ChmDrg
    {
        return $this->findOneBy(['assacDrg' => $assac]);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    // Récupérer toutes les adresses avec les infos assurés
    public function findAllWithAssures()
    {
        return $this->createQueryBuilder('d')
            ->getQuery()
            ->getResult();
    }
}
