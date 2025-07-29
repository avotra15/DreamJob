<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'users', methods:['GET'])]
    public function getUsers(
        Request $request,
        UsersRepository $usersRepo,
        JWTEncoderInterface $jwtEncoder): JsonResponse
    {
        $authHeader = $request->headers->get('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return $this->json(['message' => 'No token provided'], 401);
        }

        $token = str_replace('Bearer ', '', $authHeader);

        
        try {
            $payload = $jwtEncoder->decode($token);

            return $this->json([
                'payload' => $payload
            ]);

        $userss = $usersRepo->findAll();
        
        $dataUsers = array_map(fn($users) => [
            'id' => $users->getId(),
            'nom' => $users->getNom(),
            'roles' => $users->getRoles(),
            'email' => $users->getEmail()
        ], $userss);

         return $this->json($dataUsers);
    } catch (\Exception $e) {
            return $this->json([
                'error' => 'Invalid token',
                'details' => $e->getMessage()
            ], 400);

        }
    }
}
