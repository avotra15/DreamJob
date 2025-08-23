<?php

namespace App\Controller;


use App\Service\JobServiceInterface;
use App\Repository\JobDetailsRepository;
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

    #[Route('/listeJobs', name: 'app_listeJob', methods: ['GET'])]
    //#[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function listeJobs(
        JobDetailsRepository $JobDetailsRepository,
    ): JsonResponse {
        $listejobs = $JobDetailsRepository->getAllJobDetails();

        $dataJobs = array_map(fn($listejob) => [
            'id' => $listejob->getId(),
            'fichier' => $listejob->getFichier(),
            'titre' => $listejob->getTitre(),
            'descritpion' => $listejob->getDescription(),
            'logo' => $listejob->getLogo(),
        ], $listejobs);

         return $this->json($dataJobs);
    }

    #[Route('/job/{id}', name: 'app_job_id', methods: ['GET'])]
    public function JobId (
        int $id,
        JobDetailsRepository $JobDetailsRepository,
    ): JsonResponse {
        $job = $JobDetailsRepository->getJobDetailsById($id);

         if (!$job) {
                return $this->json([
                    'success' => false,
                    'message' => 'Offrer non trouvé.'
                ], 404);
            }

            return $this->json([
                'success' => true,
                'job' => [
                    'id' => $listejob->getId(),
                    'fichier' => $listejob->getFichier(),
                    'titre' => $listejob->getTitre(),
                    'descritpion' => $listejob->getDescription(),
                    'logo' => $listejob->getLogo(),
                ]
            ]);
    }


}
