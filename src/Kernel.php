<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

// Classe principale du noyau de l'application Symfony.
// Elle hérite du Kernel de Symfony et utilise le trait MicroKernelTrait
// pour gérer la configuration minimale et les routes de manière moderne.
class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
