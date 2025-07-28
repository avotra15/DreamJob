<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class UsersController extends AbstractController
{
    #[Route('/users', name: 'users', methods:['GET'])]
    public function getUsers(UsersRepository $usersRepo): JsonResponse
    {
        $userss = $usersRepo->findAll();

        $dataUsers = array_map(fn($users) => [
            'id' => $users->getId(),
            'nom' => $users->getNom(),
            'roles' => $users->getRoles(),
            'email' => $users->getEmail(),
            'password' => $users->getPassword()
        ], $userss);

         return $this->json($dataUsers);
    }
}
