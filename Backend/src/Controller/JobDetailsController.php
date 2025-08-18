<?php

namespace App\Controller;


use App\Service\JobServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class JobDetailsController extends AbstractController
{
   #[Route('/api/newjob', name: 'app_newjob', methods: ['POST'])]
   #[IsGranted('IS_AUTHENTICATED_FULLY')]
        public function newForm(
            JobServiceInterface $JobServiceInterface,
            Request $request,
        ): JsonResponse {
            $user = $this->getUser();

            $jobdetails = $JobServiceInterface->createJob($request, $user);

            return new JsonResponse([
                'success' => true,
                'message' => 'JobDetails créé avec succès',
                'id' => $jobdetails->getId(),
            ], 201);
    }
}
