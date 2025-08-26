<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\RolesRepository;

final class RolesController extends AbstractController
{
    #[Route('/roles', name: 'roles', methods: ['GET'])]
    public function getRoles(
        RolesRepository $roleRop
        ): JsonResponse
    {
        $roless = $roleRop->getAllRoles();

        $data = array_map(fn($roles) => [
            'id' => $roles->getId(),
            'roles' => $roles->getRoles()
        ], $roless);

         return $this->json($data);
    }
}
