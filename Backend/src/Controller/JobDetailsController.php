<?php

namespace App\Controller;

use App\Reponse\ApiReponse;
use App\Service\JobInterface;
use App\Repository\JobDetailsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class JobDetailsController extends AbstractController
{
    private ApiReponse $apiReponse;

        public function __construct(ApiReponse $apiReponse) 
    {
        $this->apiReponse = $apiReponse;

    }
   #[Route('/api/newjob', name: 'app_newjob', methods: ['POST'])]
   #[IsGranted('IS_AUTHENTICATED_FULLY')] 
        public function newForm(
            JobInterface $JobInterface,
            Request $request,
        ): JsonResponse {
            $user = $this->getUser();

            $jobdetails = $JobInterface->createJob($request, $user);

            return $this->apiReponse->sucess($jobdetails->getId(), 'JobDetails créé avec succès');
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

        return $this->apiReponse->sucess($dataJobs, 'Listes des Offres');
    }

    #[Route('/api/job/{id}', name: 'app_job_id', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function JobId (
        int $id,
        JobDetailsRepository $JobDetailsRepository,
    ): JsonResponse {
        $job = $JobDetailsRepository->getJobDetailsById($id);

         if (!$job) {
            return $this->apiReponse->error('Offre non trouvé', 404, $job);
            }

        return $this->apiReponse->sucess($job, 'Offre trouvé');
    }


}
