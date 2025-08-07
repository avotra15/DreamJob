<?php

namespace App\Controller;

use App\Entity\JobDetails;
use App\Form\JobDetailsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

final class JobDetailsController extends AbstractController
{
    #[Route('/api/newjob', name: 'app_newjob', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
    ): JsonResponse {
        $jobdetails = new JobDetails();

        $form = $this->createForm(JobDetailsType::class, $jobdetails);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $fichier = $form->get('Fichier')->getData();
            $logo = $form->get('Logo')->getData();

                if ($fichier) {
                    $Filename = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename= $slugger->slug($Filename);
                    $newFilename = $safeFilename.'-'.uniqid().'-'.$fichier->guessExtension();

                    try {
                        $fichier->move(
                            $this->getParameter('uploads_directory'),
                            $newFilename
                        );
                        $jobdetails->setFichier($newFilename);
                    } catch (FileException $e) {
                        return new JsonResponse([
                            'success' => false, 
                            'message' => 'Erreur upload'
                        ], 500);
                    }
                    

                    if ($logo) {
                    $Logoname = pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME);
                    $safelogoname= $slugger->slug($Logoname);
                    $newlogoname = $safelogoname.'-'.uniqid().'-'.$logo->guessExtension();

                    try {
                        $logo->move(
                            $this->getParameter('uploads_directory'),
                            $newlogoname
                        );
                        $jobdetails->setLogo($newlogoname);
                    } catch (FileException $e) {
                        return new JsonResponse([
                            'failure' => false, 
                            'message' => 'Erreur upload'
                        ], 500);
                    }
                }

            }
            $entityManager->persist($jobdetails);
            $entityManager->flush();

            return new JsonResponse([
                'success' => true,
                'message' => 'JobDetails créé avec succès',
            ], 200);
        }

        return new JsonResponse([
            'failure' => false,
            'message' => 'Formulaire invalide',
            'errors' => (string) $form->getErrors(true, false),
        ], 400);
    }
}
