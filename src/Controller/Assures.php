<?php

namespace App\Controller;

// Classe utilitaire pour fournir des données de test d'un assuré.
// Classe utilitaire pour fournir un jeu de données d'assurés de test.
final class Assures
{
    // Fournit un jeu de données statique utilisé pour les tests et le développement.
    // Cette méthode sert de source de données factice pour simuler un assuré.
    public static function getTestData(): array
    {
        // Retourne un tableau fixe de données simulées pour le développement.
        // Les valeurs sont volontairement figées pour permettre des tests rapides.
        // Le tableau retourné représente une fiche d'assuré factice avec ses principales données personnelles et administratives.
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
        // La valeur source indique d'où proviennent ces données factices pour faciliter leur identification en test.
        ]];
    }
}
