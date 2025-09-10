<?php

namespace App\Controller;

use App\Entity\Users;
use App\Reponse\ApiReponse;
use App\Interface\PostJobInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CVController extends AbstractController
{
    private ApiReponse $apiReponse;

        public function __construct(ApiReponse $apiReponse) 
    {
        $this->apiReponse = $apiReponse;
    }

    #[Route('/api/depotcv', name: 'app_depotcv', methods:['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function newformcv(
        PostJobInterface $postJobInterface,
        Request $request
        ): JsonResponse
    {
        
        $user = $this->getUser();

        if (!$user instanceof Users) {
            return $this->apiReponse->error('Utilisateur non authentifié', 404, $user);
        }

        $postcv = $postJobInterface->postjob($request, $user);

        return $this->apiReponse->sucess($postcv, 'Postulée avec succée');
    }
}
