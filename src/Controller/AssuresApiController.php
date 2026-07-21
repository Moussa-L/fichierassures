<?php

namespace App\Controller;

use App\Repository\ChmListeRepository;
use App\Repository\ChmDrgRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

// API REST pour exposer les informations des assurés et de leurs adresses.
#[Route('/api')]
final class AssuresApiController extends AbstractController
{
    // API REST dédiée à la consultation des assurés et de leurs adresses.
    /**
     * Récupérer tous les assurés
     */
    #[Route('/assures', name: 'api_assures_list', methods: ['GET'])]
    public function listAssures(ChmListeRepository $chmListeRepository): JsonResponse
    {
        // Appel du repository pour récupérer tous les assurés depuis la base de données.
        // Cette méthode charge la liste complète des entités assurés.
        $assures = $chmListeRepository->findAll();

        // Transformation des entités en tableau simple pour la réponse JSON.
        // Cette étape simplifie les données avant leur transmission au client.
        // Elle évite d'exposer directement les objets Doctrine.
        // Chaque objet est converti en structure clé/valeur propre à l'API.
        $data = array_map(fn($assure) => [
            'nir' => $assure->getAssmacBen(), // NIR principal de l'assuré
            'nirBnf' => $assure->getMacbenBen(), // NIR de la personne bénéficiaire
            'nom' => $assure->getNomstdBen(), // Nom standardisé
            'prenom' => $assure->getNomprmBen(), // Prénom de l'assuré
            'dateNaissance' => $assure->getNaidatB()?->format('Y-m-d'), // Date de naissance formatée
            'dateTraitement' => $assure->getJoddsdJ()?->format('Y-m-d'), // Date de traitement formatée
        ], $assures);

        // Retourne la réponse JSON avec la liste des assurés.
        return $this->json($data);
    }

    /**
     * Récupérer un assuré par NIR
     */
    #[Route('/assures/{nir}', name: 'api_assure_detail', methods: ['GET'])]
    public function getAssure(string $nir, ChmListeRepository $chmListeRepository, ChmDrgRepository $chmDrgRepository): JsonResponse
    {
        // Recherche l'assuré dans la table chm_liste par son NIR.
        // Le paramètre $nir est utilisé comme identifiant principal de recherche.
        $assure = $chmListeRepository->findByNir($nir);

        // Si aucun assuré n'est trouvé, on renvoie une erreur 404.
        // Cela permet à l'API d'indiquer clairement un identifiant introuvable.
        // Cela permet à l'API de signaler que l'identifiant demandé est invalide.
        if (!$assure) {
            return $this->json(['error' => 'Assuré non trouvé'], Response::HTTP_NOT_FOUND);
        }

        // Récupérer l'adresse associée à l'assuré via le repository chm_drg.
        $adresse = $chmDrgRepository->findByAssac($nir);

        // Prépare les données de l'assuré avec son adresse si elle existe.
        // Le champ adresse peut être nul si aucune information n'est stockée.
        // Cette structure est directement consommable par un client JSON.
        $data = [
            'nir' => $assure->getAssmacBen(),
            'nirBnf' => $assure->getMacbenBen(),
            'nom' => $assure->getNomstdBen(),
            'prenom' => $assure->getNomprmBen(),
            'dateNaissance' => $assure->getNaidatB()?->format('Y-m-d'),
            'dateTraitement' => $assure->getJoddsdJ()?->format('Y-m-d'),
            'adresse' => $adresse ? [
                'type' => $adresse->getVoitypDrg(),
                'libelle' => $adresse->getVoilibDrg(),
                'complement' => $adresse->getCplDrg(),
                'codePostal' => $adresse->getCdptDrg(),
                'commune' => $adresse->getCmmuneDrg(),
            ] : null,
        ];

        // Retourne la réponse JSON pour l'assuré demandé.
        return $this->json($data);
    }

    /**
     * Récupérer toutes les adresses
     */
    #[Route('/adresses', name: 'api_adresses_list', methods: ['GET'])]
    public function listAdresses(ChmDrgRepository $chmDrgRepository): JsonResponse
    {
        // Récupération de toutes les adresses stockées.
        // Cette méthode sert à exposer le catalogue des adresses au format API.
        $adresses = $chmDrgRepository->findAll();
        
        // Conversion de chaque entité adresse en tableau simple.
        // Cette transformation produit un tableau associatif facile à encoder en JSON.
        $data = array_map(fn($adresse) => [
            'nir' => $adresse->getAssacDrg(),
            'type' => $adresse->getVoitypDrg(),
            'libelle' => $adresse->getVoilibDrg(),
            'complement' => $adresse->getCplDrg(),
            'codePostal' => $adresse->getCdptDrg(),
            'commune' => $adresse->getCmmuneDrg(),
        ], $adresses);

        // Retourne la réponse JSON contenant toutes les adresses.
        return $this->json($data);
    }

    /**
     * Récupérer adresse par NIR
     */
    #[Route('/adresses/{nir}', name: 'api_adresse_detail', methods: ['GET'])]
    public function getAdresse(string $nir, ChmDrgRepository $chmDrgRepository): JsonResponse
    {
        // Recherche l'adresse correspondant au NIR passé en paramètre.
        // Le repository recherche l'enregistrement d'adresse lié à cet identifiant.
        $adresse = $chmDrgRepository->findByAssac($nir);

        // Si l'adresse n'existe pas, on renvoie une erreur 404.
        // Ce code HTTP indique clairement que la ressource demandée est introuvable.
        if (!$adresse) {
            return $this->json(['error' => 'Adresse non trouvée'], Response::HTTP_NOT_FOUND);
        }

        // Prépare les données de l'adresse à retourner.
        // Le tableau généré correspond exactement au format attendu par le client API.
        $data = [
            'nir' => $adresse->getAssacDrg(),
            'type' => $adresse->getVoitypDrg(),
            'libelle' => $adresse->getVoilibDrg(),
            'complement' => $adresse->getCplDrg(),
            'codePostal' => $adresse->getCdptDrg(),
            'commune' => $adresse->getCmmuneDrg(),
        ];

        // Retourne la réponse JSON pour l'adresse demandée.
        return $this->json($data);
    }

    /**
     * Récupérer assurés avec leurs adresses (jointure complète)
     */
    #[Route('/assures-avec-adresses', name: 'api_assures_with_adresses', methods: ['GET'])]
    public function listAssuresWithAdresses(ChmListeRepository $chmListeRepository, ChmDrgRepository $chmDrgRepository): JsonResponse
    {
        // Récupération de tous les assurés.
        // Cette méthode prépare un rendu enrichi avec l'adresse associée.
        $assures = $chmListeRepository->findAll();

        // Ajoute l'adresse à chaque assuré si elle est disponible.
        // L'API retourne ainsi un format plus complet pour l'affichage.
        $data = array_map(fn($assure) => [
            'nir' => $assure->getAssmacBen(),
            'nirBnf' => $assure->getMacbenBen(),
            'nom' => $assure->getNomstdBen(),
            'prenom' => $assure->getNomprmBen(),
            'dateNaissance' => $assure->getNaidatB()?->format('Y-m-d'),
            'dateTraitement' => $assure->getJoddsdJ()?->format('Y-m-d'),
            'adresse' => ($adresse = $chmDrgRepository->findByAssac($assure->getAssmacBen())) ? [
                'type' => $adresse->getVoitypDrg(),
                'libelle' => $adresse->getVoilibDrg(),
                'complement' => $adresse->getCplDrg(),
                'codePostal' => $adresse->getCdptDrg(),
                'commune' => $adresse->getCmmuneDrg(),
            ] : null,
        ], $assures);

        // Retourne la réponse JSON avec les assurés et leurs adresses.
        return $this->json($data);
    }
}
