<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\Table(name: 'users')]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $numAgent = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nomPrenom = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $password = null;

    public function __construct (string $numAgent, string $nomPrenom, string $password)
    {
        $this->numAgent = $numAgent;
        $this->nomPrenom = $nomPrenom;
        $this->password = $password;

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

    public function listingUsers(){
        return $this->listingUsers;
    }


}










?>