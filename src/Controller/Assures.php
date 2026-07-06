<?php

namespace App\Controller;

final class Assures
{
    public static function getTestData(): array
    {
        return [[
            'nir' => '2901199397081',
            'nirBnf' => '1250497612003',
            'nom' => 'MADI',
            'prenom' => 'IRCHAM MOURSAL',
            'dateTraitement' => new \DateTime('2025-04-14'),
            'lieuNaissance' => 'MARRAKECH',
            'dateNaissance' => new \DateTime('1993-01-29'),
            'adresse' => '123 Rue de la Liberté',
            'addresseComplete' => '123 Rue de la Liberté, Marrakech',
            'dateFinJOD' => new \DateTime('2025-04-14'),
            'source' => 'Source A',
            
        ]];
    }
}
