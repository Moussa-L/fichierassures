<?php

use App\Kernel;

// Charge l'autoloader de Symfony pour pouvoir utiliser les classes de l'application.
require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

// Point d'entrée de l'application Symfony.
// Crée une instance du noyau avec l'environnement et le mode debug fournis par le contexte.
return static function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
