<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class UsersController extends AbstractController
{
    #[Route('/api/users', name: 'users', methods:['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function getUsers(
        UsersRepository $usersRepo,
        ): JsonResponse
    {
        $userss = $usersRepo->findAll();

        $dataUsers = array_map(fn($users) => [
            'id' => $users->getId(),
            'nom' => $users->getNom(),
            'roles' => $users->getRoles(),
            'email' => $users->getEmail()
        ], $userss);

         return $this->json($dataUsers);
    }
}
