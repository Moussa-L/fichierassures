<?php

namespace App\Controller;

// Classe utilitaire pour fournir des données de test d'un assuré.
// Classe utilitaire pour fournir un jeu de données d'assurés de test.
final class Assures
{
    // Fournit un jeu de données statique utilisé pour les tests et le développement.
    public static function getTestData(): array
    {
        // Retourne un tableau fixe de données simulées pour le développement.
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
