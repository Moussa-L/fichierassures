<?php

namespace App\Entity;

use App\Repository\CoordonneeRepository;

// Entité pour représenter les coordonnées détaillées d'un assuré.
// Les propriétés sont utilisées pour stocker les informations personnelles et l'adresse.
class Coordonnee
{
    // Stocke les informations détaillées d'un assuré et de son adresse.
    // NIR principal de l'assuré.
    private ?string $nirAss = null;
    // NIR du bénéficiaire associé.
    private ?string $nirBnf = null;
    // Nom de l'assuré.
    private ?string $nom = null;
    // Prénom de l'assuré.
    private ?string $prenom = null;
    // Date de naissance de l'assuré.
    private ?string $dateNaissance = null;
    // Lieu de naissance de l'assuré.
    private ?string $lieuNaissance = null;
    // Adresse principale de l'assuré.
    private ?string $addresse = null;
    // Adresse complète formatée pour l'affichage.
    private ?string $addresseComplete = null;
    // Date de fin de la JOD.
    private ?string $dateFinJOD = null;
    // Source de provenance des données.
    private ?string $source;

    public function __construct(){
    }

    public function getNir(){
        // Retourne le NIR principal de l'assuré.
        // Cette valeur représente l'identifiant principal utilisé pour les opérations de recherche.
        return $this->nirAss; 
    }
    public function setNir(string $nirAss){
        // Définit le NIR principal de l'assuré.
        $this->nirAss = $nirAss;
        return $this;
    }
    public function getNirBnf(){
        // Retourne le NIR du bénéficiaire associé à l'assuré.
        return $this->nirBnf;
    }
    public function setNirBnf(string $nirBnf){
        $this->nirBnf = $nirBnf;
        return $this;
    }
    public function getNom(){
        // Retourne le nom de l'assuré.
        return $this->nom;
    }
    public function setNom(string $nom){
        $this->nom = $nom;
        return $this;
    }
    public function getPrenom(){
        // Retourne le prénom de l'assuré.
        return $this->prenom;
    }
    public function setPrenom(string $prenom){
        $this->prenom = $prenom;
        return $this;
    }
    public function getDateNaissance(){
        // Retourne la date de naissance stockée dans l'objet.
        return $this->dateNaissance;
    }
    public function setDateNaissance(string $dateNaissance){
        $this->dateNaissance = $dateNaissance;
        return $this;
    }
    public function getLieuNaissance(){
        // Retourne le lieu de naissance de l'assuré.
        return $this->lieuNaissance;
    }
    public function setLieuNaissance(string $lieuNaissance){
        $this->lieuNaissance = $lieuNaissance;
        return $this;
    }
    public function getAddresse(){
        // Retourne l'adresse simple de l'assuré.
        return $this->addresse;
    }
    public function setAddresse(string $addresse){
        $this->addresse = $addresse;
        return $this;
    }
    public function getAddresseComplete(){
        // Retourne l'adresse complète déjà formatée pour l'affichage.
        return $this->addresseComplete;
    }
    public function setAddresseComplete(string $addresseComplete){
        $this->addresseComplete = $addresseComplete;
        return $this;
    }
    public function getDateFinJOD(){
        // Retourne la date de fin de la JOD.
        return $this->dateFinJOD;
    }
    public function setDateFinJOD(string $dateFinJOD){
        $this->dateFinJOD = $dateFinJOD;
        return $this;
    }
    public function getSource(){
        // Retourne la source de provenance des données de l'assuré.
        return $this->source;
    }
    public function setSource(string $source){
        $this->source = $source;
        return $this;
    }
}
