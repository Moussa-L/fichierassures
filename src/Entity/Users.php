<?php

namespace App\Entity;

use App\Repository\UsersRepository;

// Entité représentant un utilisateur du système.
// Cette classe encapsule le numéro d'agent, le nom complet et le mot de passe.
class Users
{
    private ?string $numAgent = null;
    private ?string $nomPrenom = null;
    private ?string $password = null;

    public function __construct (string $numAgent, string $nomPrenom, string $password)
    {
        $this->numAgent = $numAgent;
        $this->nomPrenom = $nomPrenom;
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