<?php

namespace App\Entity;

use App\Repository\CoordonneeRepository;

// Entité pour représenter les coordonnées détaillées d'un assuré.
// Les propriétés sont utilisées pour stocker les informations personnelles et l'adresse.
class Coordonnee
{
    // Stocke les informations détaillées d'un assuré et de son adresse.
    private ?string $nirAss = null;
    private ?string $nirBnf = null;
    private ?string $nom = null;
    private ?string $prenom = null;
    private ?string $dateNaissance = null;
    private ?string $lieuNaissance = null;
    private ?string $addresse = null;
    private ?string $addresseComplete = null;         
    private ?string $dateFinJOD = null;
    private ?string $source;

    public function __construct(){
    }

    public function getNir(){
        // Retourne le NIR principal de l'assuré.
        return $this->nirAss; 
    }
    public function setNir(string $nirAss){
        // Définit le NIR principal de l'assuré.
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
