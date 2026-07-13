<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

// Classe principale du noyau de l'application Symfony.
// Elle hérite du Kernel de Symfony et active le trait MicroKernelTrait
// pour permettre une configuration minimale et la gestion des routes.
class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
