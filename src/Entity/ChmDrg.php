<?php

namespace App\Entity;

use App\Repository\ChmDrgRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChmDrgRepository::class)]
#[ORM\Table(name: 'chm_drg')]
class ChmDrg
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $assacDrg = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $voitypDrg = null;

    #[ORM\Column(type: 'string', length: 500, nullable: true)]
    private ?string $voilibDrg = null;

    #[ORM\Column(type: 'string', length: 500, nullable: true)]
    private ?string $cplDrg = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $cdptDrg = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $cmmuneDrg = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssacDrg(): ?string
    {
        return $this->assacDrg;
    }

    public function setAssacDrg(string $assacDrg): self
    {
        $this->assacDrg = $assacDrg;
        return $this;
    }

    public function getVoitypDrg(): ?string
    {
        return $this->voitypDrg;
    }

    public function setVoitypDrg(?string $voitypDrg): self
    {
        $this->voitypDrg = $voitypDrg;
        return $this;
    }

    public function getVoilibDrg(): ?string
    {
        return $this->voilibDrg;
    }

    public function setVoilibDrg(?string $voilibDrg): self
    {
        $this->voilibDrg = $voilibDrg;
        return $this;
    }

    public function getCplDrg(): ?string
    {
        return $this->cplDrg;
    }

    public function setCplDrg(?string $cplDrg): self
    {
        $this->cplDrg = $cplDrg;
        return $this;
    }

    public function getCdptDrg(): ?string
    {
        return $this->cdptDrg;
    }

    public function setCdptDrg(?string $cdptDrg): self
    {
        $this->cdptDrg = $cdptDrg;
        return $this;
    }

    public function getCmmuneDrg(): ?string
    {
        return $this->cmmuneDrg;
    }

    public function setCmmuneDrg(?string $cmmuneDrg): self
    {
        $this->cmmuneDrg = $cmmuneDrg;
        return $this;
    }
}
