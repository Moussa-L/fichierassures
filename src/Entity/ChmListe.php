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
    // Propriétés mappées à la table chm_liste du schéma dbo.
    // Clé primaire représentant le NIR principal de l'assuré.
    #[ORM\Id]
    #[ORM\Column(name: 'ASSMAC_BEN', type: 'string', length: 50)]
    private ?string $assmacBen = null;

    // NIR secondaire ou numéro bénéficiaire associé à l'assuré.
    #[ORM\Column(name: 'MACBEN_BEN', type: 'string', length: 50, nullable: true)]
    private ?string $macbenBen = null;

    // Nom standardisé de l'assuré tel que utilisé par le système.
    #[ORM\Column(name: 'NOMSTD_BEN', type: 'string', length: 255, nullable: true)]
    private ?string $nomstdBen = null;

    // Prénom ou prénom complet de l'assuré.
    #[ORM\Column(name: 'NOMPRM_BEN', type: 'string', length: 255, nullable: true)]
    private ?string $nomprmBen = null;

    // Date de naissance de l'assuré, si elle est renseignée.
    #[ORM\Column(name: 'NAIDAT_B', type: 'datetime', nullable: true)]
    private ?\DateTime $naidatB = null;

    // Date de traitement liée à la situation de l'assuré.
    #[ORM\Column(name: 'JODDSD_J', type: 'datetime', nullable: true)]
    private ?\DateTime $joddsdJ = null;

    public function getAssmacBen(): ?string
    {
        // Retourne le NIR principal de l'assuré.
        // Cette valeur sert d'identifiant principal dans les traitements et les recherches.
        return $this->assmacBen;
    }

    public function setAssmacBen(string $assmacBen): self
    {
        // Définit le NIR principal de l'assuré.
        // Cette méthode met à jour la valeur de la propriété avec le nouvel identifiant.
        $this->assmacBen = $assmacBen;
        return $this;
    }

    public function getMacbenBen(): ?string
    {
        // Retourne le second identifiant ou bénéficiaire associé à la ligne de l'assuré.
        return $this->macbenBen;
    }

    public function setMacbenBen(?string $macbenBen): self
    {
        $this->macbenBen = $macbenBen;
        return $this;
    }

    public function getNomstdBen(): ?string
    {
        // Retourne le nom standardisé de l'assuré.
        return $this->nomstdBen;
    }

    public function setNomstdBen(?string $nomstdBen): self
    {
        $this->nomstdBen = $nomstdBen;
        return $this;
    }

    public function getNomprmBen(): ?string
    {
        // Retourne le prénom ou le prénom complet de l'assuré.
        return $this->nomprmBen;
    }

    public function setNomprmBen(?string $nomprmBen): self
    {
        $this->nomprmBen = $nomprmBen;
        return $this;
    }

    public function getNaidatB(): ?\DateTime
    {
        // Retourne la date de naissance stockée dans l'entité.
        return $this->naidatB;
    }

    public function setNaidatB(?\DateTime $naidatB): self
    {
        $this->naidatB = $naidatB;
        return $this;
    }

    public function getJoddsdJ(): ?\DateTime
    {
        // Retourne la date de traitement associée à l'assuré.
        return $this->joddsdJ;
    }

    public function setJoddsdJ(?\DateTime $joddsdJ): self
    {
        $this->joddsdJ = $joddsdJ;
        return $this;
    }
}
