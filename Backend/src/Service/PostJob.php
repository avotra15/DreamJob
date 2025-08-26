<?php

namespace App\Service;

use App\Entity\CV;
use App\Entity\Users;
use App\ServiceInterface\PostJobInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class PostJob implements PostJobInterface {
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function postjob(Request $req, Users $user): CV {
        $cv = $req->files->get('CV');

        $newCV = new CV();

        $newCV->setNamecv($cv);
        $newCV->setEmail($user);

        $entityManager->persist($newCV);
        $entityManager->flush();
    }
}