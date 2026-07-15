<?php

namespace App\Entity;

use App\Repository\ChmListeRepository;
use Doctrine\ORM\Mapping as ORM;

// Entité représentant un assuré dans la table chm_liste.
// Les annotations ORM établissent la correspondance avec la base de données.
#[ORM\Entity(repositoryClass: ChmListeRepository::class)]
#[ORM\Table(name: 'chm_liste', schema: 'dbo')]
class ChmListe
{
    #[ORM\Id]
    #[ORM\Column(name: 'ASSMAC_BEN', type: 'string', length: 50)]
    private ?string $assmacBen = null;

    #[ORM\Column(name: 'MACBEN_BEN', type: 'string', length: 50, nullable: true)]
    private ?string $macbenBen = null;

    #[ORM\Column(name: 'NOMSTD_BEN', type: 'string', length: 255, nullable: true)]
    private ?string $nomstdBen = null;

    #[ORM\Column(name: 'NOMPRM_BEN', type: 'string', length: 255, nullable: true)]
    private ?string $nomprmBen = null;

    #[ORM\Column(name: 'NAIDAT_B', type: 'datetime', nullable: true)]
    private ?\DateTime $naidatB = null;

    #[ORM\Column(name: 'JODDSD_J', type: 'datetime', nullable: true)]
    private ?\DateTime $joddsdJ = null;

    public function getAssmacBen(): ?string
    {
        // Retourne le NIR principal de l'assuré.
        return $this->assmacBen;
    }

    public function setAssmacBen(string $assmacBen): self
    {
        // Définit le NIR principal de l'assuré.
        $this->assmacBen = $assmacBen;
        return $this;
    }

    public function getMacbenBen(): ?string
    {
        return $this->macbenBen;
    }

    public function setMacbenBen(?string $macbenBen): self
    {
        $this->macbenBen = $macbenBen;
        return $this;
    }

    public function getNomstdBen(): ?string
    {
        return $this->nomstdBen;
    }

    public function setNomstdBen(?string $nomstdBen): self
    {
        $this->nomstdBen = $nomstdBen;
        return $this;
    }

    public function getNomprmBen(): ?string
    {
        return $this->nomprmBen;
    }

    public function setNomprmBen(?string $nomprmBen): self
    {
        $this->nomprmBen = $nomprmBen;
        return $this;
    }

    public function getNaidatB(): ?\DateTime
    {
        return $this->naidatB;
    }

    public function setNaidatB(?\DateTime $naidatB): self
    {
        $this->naidatB = $naidatB;
        return $this;
    }

    public function getJoddsdJ(): ?\DateTime
    {
        return $this->joddsdJ;
    }

    public function setJoddsdJ(?\DateTime $joddsdJ): self
    {
        $this->joddsdJ = $joddsdJ;
        return $this;
    }
}
