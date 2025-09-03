<?php

namespace App\Service;

use App\Entity\JobDetails;
use App\Entity\Users;
use App\Service\JobInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class JobService implements JobInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function createJob(Request $request, Users $user): JobDetails
     {
            $fichierFile = $request->files->get('fichierFile');
            $titre = $request->request->get('titre', '');
            $description = $request->request->get('description', '');
            $logoFile = $request->files->get('logoFile');

            $jobdetails = new JobDetails();
            
            $jobdetails->setFichierFile($fichierFile);
            $jobdetails->setTitre($titre);
            $jobdetails->setDescription($description);
            $jobdetails->setLogoFile($logoFile);
            $jobdetails->setEmail($user);

            $this->entityManager->persist($jobdetails);
            $this->entityManager->flush();

            return $jobdetails;

    }

    public function deleteJob (JobDetails $jobdetails): void {
            $this->entityManager->persist($jobdetails);
            $this->entityManager->flush();
    }
}
?>