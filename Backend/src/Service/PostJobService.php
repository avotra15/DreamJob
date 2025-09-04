<?php

namespace App\Service;

use App\Entity\CV;
use App\Entity\Users;
use App\Service\PostJobInterface as ServicePostJobInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class PostJobService implements ServicePostJobInterface {
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function postjob(Request $req, Users $user): CV {
        $cv = $req->files->get('cv');

        $newCV = new CV();

        $newCV->setNamecv($cv);
        $newCV->setEmailCand($user);

        $this->entityManager->persist($newCV);
        $this->entityManager->flush();

        return new CV();
    }
}