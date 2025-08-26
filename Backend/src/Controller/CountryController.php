<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class CountryController extends AbstractController
{
    #[Route('/country', name: 'app_country', methods: ['GET'])]
    public function getCountry(
        CountryRepository $countryRep
    ): JsonResponse
    {
       $countrys = $countryRep->getAllCountry();

        $data = array_map(fn($country) => [
            'id' => $country->getId(),
            'name' => $country->getName(),
            'code' => $country->getCode()
        ], $countrys);

         return $this->json($data);
    }
}
