<?php

namespace App\Entity;

use App\Repository\ChmDrgRepository;
use Doctrine\ORM\Mapping as ORM;

// Entité représentant l'adresse d'un assuré dans la table chm_drg.
// Cette classe collecte toutes les informations de localisation.
#[ORM\Entity(repositoryClass: ChmDrgRepository::class)]
#[ORM\Table(name: 'chm_drg', schema: 'dbo')]
class ChmDrg
{
    // Propriétés représentant les informations d'adresse d'un assuré.
    // Identifiant interne de l'enregistrement d'adresse.
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer')]
    private ?int $id = null;

    // Code d'association de l'adresse à l'assuré.
    #[ORM\Column(name: 'ASSAC_DRG', type: 'string', length: 50)]
    private ?string $assacDrg = null;

    // Type de voie de l'adresse (rue, avenue, boulevard, etc.).
    #[ORM\Column(name: 'VOITYP_DRG', type: 'string', length: 50, nullable: true)]
    private ?string $voitypDrg = null;

    // Libellé de la voie correspondant à l'adresse.
    #[ORM\Column(name: 'VOILIB_DRG', type: 'string', length: 500, nullable: true)]
    private ?string $voilibDrg = null;

    // Complément d'adresse éventuel (bâtiment, étage, appartement).
    #[ORM\Column(name: 'CPL_DRG', type: 'string', length: 500, nullable: true)]
    private ?string $cplDrg = null;

    // Code postal de l'adresse.
    #[ORM\Column(name: 'CDPT_DRG', type: 'string', length: 10, nullable: true)]
    private ?string $cdptDrg = null;

    // Commune ou localité de l'adresse.
    #[ORM\Column(name: 'CMMUNE_DRG', type: 'string', length: 255, nullable: true)]
    private ?string $cmmuneDrg = null;

    public function getId(): ?int
    {
        // Retourne la clé primaire de l'entité adresse.
        // Cette valeur est généralement utilisée comme identifiant interne.
        return $this->id;
    }

    public function getAssacDrg(): ?string
    {
        // Fournit le code d'association de l'adresse à l'assuré.
        return $this->assacDrg;
    }

    public function setAssacDrg(string $assacDrg): self
    {
        // Définit le code d'association de l'adresse.
        $this->assacDrg = $assacDrg;
        return $this;
    }

    public function getVoitypDrg(): ?string
    {
        // Retourne le type de voie de l'adresse, par exemple rue ou avenue.
        return $this->voitypDrg;
    }

    public function setVoitypDrg(?string $voitypDrg): self
    {
        // Met à jour le type de voie stocké dans l'entité.
        $this->voitypDrg = $voitypDrg;
        return $this;
    }

    public function getVoilibDrg(): ?string
    {
        // Retourne le libellé complet de la voie de l'adresse.
        return $this->voilibDrg;
    }

    public function setVoilibDrg(?string $voilibDrg): self
    {
        // Met à jour le libellé de voie de l'adresse.
        $this->voilibDrg = $voilibDrg;
        return $this;
    }

    public function getCplDrg(): ?string
    {
        // Retourne le complément d'adresse, s'il existe.
        return $this->cplDrg;
    }

    public function setCplDrg(?string $cplDrg): self
    {
        // Définit le complément d'adresse éventuel.
        $this->cplDrg = $cplDrg;
        return $this;
    }

    public function getCdptDrg(): ?string
    {
        // Retourne le code postal associé à l'adresse.
        return $this->cdptDrg;
    }

    public function setCdptDrg(?string $cdptDrg): self
    {
        // Met à jour le code postal de l'adresse.
        $this->cdptDrg = $cdptDrg;
        return $this;
    }

    public function getCmmuneDrg(): ?string
    {
        // Retourne la commune ou la localité de l'adresse.
        return $this->cmmuneDrg;
    }

    public function setCmmuneDrg(?string $cmmuneDrg): self
    {
        // Met à jour la commune de l'adresse.
        $this->cmmuneDrg = $cmmuneDrg;
        return $this;
    }
}
