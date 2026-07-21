<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

// Classe principale du noyau de l'application Symfony.
// Elle hérite du Kernel de Symfony et active le trait MicroKernelTrait
// pour permettre une configuration minimale et la gestion des routes.
// Cette classe sert de point central d'initialisation pour le framework Symfony.
class Kernel extends BaseKernel
{
    // Point d'entrée du kernel Symfony de l'application.
    // Cette classe initialise le comportement global de l'application.
    // Le trait MicroKernelTrait permet d'ajouter un comportement léger et modulaire au kernel.
    use MicroKernelTrait;
}
