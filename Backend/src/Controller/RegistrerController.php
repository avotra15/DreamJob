<?php

namespace App\Controller;

use App\Repository\RolesRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class RegistrerController extends AbstractController
{
    #[Route('/registrer', name: 'registrer', methods:['POST'])]
    public function create(
        Request $request,
        UsersRepository $usersRepository,
        RolesRepository $rolesRepository
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['Email'];
        if ($usersRepository->emailExists($email)) {
            return new JsonResponse([
                'failure' => false,
                'message' => 'Email déjà utilisé'],400);
        }

        $roleName = $data['Roles'] ?? null;
        $role = $rolesRepository->findByName($roleName);
        if(!$role) {
            return $this->json(['success' => false, 'message' => 'Rôle invalide'], 400);
        }
       
        $user = $usersRepository->createUser($data, $role);

            return $this->json([
                'success' => true,
                'messages' => 'User créer avec succès',
                'id' => $user->getId(),
            ], 200);
            $this->redirectToRoute('login');
            } 
}