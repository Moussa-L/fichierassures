<?php

namespace App\Controller;

use App\Repository\ChmListeRepository;
use App\Repository\ChmDrgRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api')]
final class AssuresApiController extends AbstractController
{
    /**
     * Récupérer tous les assurés
     */
    #[Route('/assures', name: 'api_assures_list', methods: ['GET'])]
    public function listAssures(ChmListeRepository $chmListeRepository): JsonResponse
    {
        $assures = $chmListeRepository->findAll();
        
        $data = array_map(fn($assure) => [
            'nir' => $assure->getAssmacBen(),
            'nirBnf' => $assure->getMacbenBen(),
            'nom' => $assure->getNomstdBen(),
            'prenom' => $assure->getNomprmBen(),
            'dateNaissance' => $assure->getNaidatB()?->format('Y-m-d'),
            'dateTraitement' => $assure->getJoddsdJ()?->format('Y-m-d'),
        ], $assures);

        return $this->json($data);
    }

    /**
     * Récupérer un assuré par NIR
     */
    #[Route('/assures/{nir}', name: 'api_assure_detail', methods: ['GET'])]
    public function getAssure(string $nir, ChmListeRepository $chmListeRepository, ChmDrgRepository $chmDrgRepository): JsonResponse
    {
        $assure = $chmListeRepository->findByNir($nir);
        
        if (!$assure) {
            return $this->json(['error' => 'Assuré non trouvé'], Response::HTTP_NOT_FOUND);
        }

        // Récupérer l'adresse associée via la jointure
        $adresse = $chmDrgRepository->findByAssac($nir);

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

        return $this->json($data);
    }

    /**
     * Récupérer toutes les adresses
     */
    #[Route('/adresses', name: 'api_adresses_list', methods: ['GET'])]
    public function listAdresses(ChmDrgRepository $chmDrgRepository): JsonResponse
    {
        $adresses = $chmDrgRepository->findAll();
        
        $data = array_map(fn($adresse) => [
            'nir' => $adresse->getAssacDrg(),
            'type' => $adresse->getVoitypDrg(),
            'libelle' => $adresse->getVoilibDrg(),
            'complement' => $adresse->getCplDrg(),
            'codePostal' => $adresse->getCdptDrg(),
            'commune' => $adresse->getCmmuneDrg(),
        ], $adresses);

        return $this->json($data);
    }

    /**
     * Récupérer adresse par NIR
     */
    #[Route('/adresses/{nir}', name: 'api_adresse_detail', methods: ['GET'])]
    public function getAdresse(string $nir, ChmDrgRepository $chmDrgRepository): JsonResponse
    {
        $adresse = $chmDrgRepository->findByAssac($nir);
        
        if (!$adresse) {
            return $this->json(['error' => 'Adresse non trouvée'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'nir' => $adresse->getAssacDrg(),
            'type' => $adresse->getVoitypDrg(),
            'libelle' => $adresse->getVoilibDrg(),
            'complement' => $adresse->getCplDrg(),
            'codePostal' => $adresse->getCdptDrg(),
            'commune' => $adresse->getCmmuneDrg(),
        ];

        return $this->json($data);
    }

    /**
     * Récupérer assurés avec leurs adresses (jointure complète)
     */
    #[Route('/assures-avec-adresses', name: 'api_assures_with_adresses', methods: ['GET'])]
    public function listAssuresWithAdresses(ChmListeRepository $chmListeRepository, ChmDrgRepository $chmDrgRepository): JsonResponse
    {
        $assures = $chmListeRepository->findAll();
        
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

        return $this->json($data);
    }
}
