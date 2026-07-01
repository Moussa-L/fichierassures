<?php

namespace App\Entity;

use App\Repository\UsersRepository;

class Users
{
    private ?string $numAgent = null;
    private ?string $nomPrenom = null;
    private ?string $password = null;

    public function __construct (){

    }

    public function getNumAgent(){
        return $this->numAgent;
    }

    public function setNumAgent(string $numAgent){
        $this->numAgent = $numAgent;
        return $this;
    }

    public function getNomPrenom(){
        return $this->nomPrenom;
    }

    public function setNomPrenom(string $nomPrenom){
        $this->nomPrnom = $nomPrenom;
        return $this;
    }
    
    public function getPassword(){
        return $this->password;
    }

    public function setPassword(string $password){
        $this->password = $password;
        return $this;
    }


}










?>