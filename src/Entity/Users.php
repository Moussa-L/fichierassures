<?php

namespace App\Entity;

use App\Repository\UsersRepository;

// Entité représentant un utilisateur du système.
// Cette classe encapsule le numéro d'agent, le nom complet et le mot de passe.
class Users
{
    // Propriétés principales d'un utilisateur du système.
    // Identifiant unique de l'agent utilisateur.
    private ?string $numAgent = null;
    // Nom et prénom complet de l'utilisateur.
    private ?string $nomPrenom = null;
    // Mot de passe stocké en mémoire pour l'usage du système.
    private ?string $password = null;

    // Initialise un nouvel utilisateur avec ses informations de base.
    // Les trois paramètres fournis correspondent aux données minimales nécessaires à la création d'un utilisateur.
    public function __construct (string $numAgent, string $nomPrenom, string $password)
    {
        // Affecte l'identifiant de l'agent.
        $this->numAgent = $numAgent;
        // Affecte le nom complet de l'utilisateur.
        $this->nomPrenom = $nomPrenom;
        // Affecte le mot de passe utilisateur.
        $this->password = $password;
    }

    // Récupère le numéro de l'agent.
    public function getNumAgent(){
        return $this->numAgent;
    }

    // Définit le numéro de l'agent.
    public function setNumAgent(string $numAgent){
        $this->numAgent = $numAgent;
        return $this;
    }

    // Récupère le nom et prénom de l'utilisateur.
    public function getNomPrenom(){
        return $this->nomPrenom;
    }

    // Définit le nom et prénom de l'utilisateur.
    public function setNomPrenom(string $nomPrenom){
        $this->nomPrnom = $nomPrenom;
        return $this;
    }
    
    // Récupère le mot de passe de l'utilisateur.
    public function getPassword(){
        return $this->password;
    }

    // Définit le mot de passe de l'utilisateur.
    public function setPassword(string $password){
        $this->password = $password;
        return $this;
    }

    // Méthode de listing non utilisée actuellement.
    public function listingUsers(){
        return $this->listingUsers;
    }


}










?>