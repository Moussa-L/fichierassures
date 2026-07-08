<?php

namespace App\Entity;

use App\Repository\CoordonneeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoordonneeRepository::class)]
#[ORM\Table(name: 'coordonnees_assures')]
class Coordonnee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $nirAss = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $nirBnf = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $dateNaissance = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $lieuNaissance = null;

    #[ORM\Column(type: 'string', length: 500)]
    private ?string $addresse = null;

    #[ORM\Column(type: 'string', length: 500)]
    private ?string $addresseComplete = null;         

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $dateFinJOD = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $source;


    public function __construct(){

    }

    public function getNir(){
        return $this->nirAss; 
    }
    public function setNir(string $nirAss){
        $this->nirAss = $nirAss;
        return $this;
    }
    public function getNirBnf(){
        return $this->nirBnf;
    }
    public function setNirBnf(string $nirBnf){
        $this->nirBnf = $nirBnf;
        return $this;
    }
    public function getNom(){
        return $this->nom;
    }
    public function setNom(string $nom){
        $this->nom = $nom;
        return $this;
    }
    public function getPrenom(){
        return $this->prenom;
    }
    public function setPrenom(string $prenom){
        $this->prenom = $prenom;
        return $this;
    }
    public function getDateNaissance(){
        return $this->dateNaissance;
    }
    public function setDateNaissance(string $dateNaissance){
        $this->dateNaissance = $dateNaissance;
        return $this;
    }
    public function getLieuNaissance(){
        return $this->lieuNaissance;
    }
    public function setLieuNaissance(string $lieuNaissance){
        $this->lieuNaissance = $lieuNaissance;
        return $this;
    }
    public function getAddresse(){
        return $this->addresse;
    }
    public function setAddresse(string $addresse){
        $this->addresse = $addresse;
        return $this;
    }
    public function getAddresseComplete(){
        return $this->addresseComplete;
    }
    public function setAddresseComplete(string $addresseComplete){
        $this->addresseComplete = $addresseComplete;
        return $this;
    }
    public function getDateFinJOD(){
        return $this->dateFinJOD;
    }
    public function setDateFinJOD(string $dateFinJOD){
        $this->dateFinJOD = $dateFinJOD;
        return $this;
    }
    public function getSource(){
        return $this->source;
    }
    public function setSource(string $source){
        $this->source = $source;
        return $this;
    }

}

?> 
