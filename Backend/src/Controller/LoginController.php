<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class LoginController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ['POST'])]
    
    public function index(
        Request $request,
        JWTTokenManagerInterface $jwtManager,
        UsersRepository $usersRepository,
        UserPasswordHasherInterface $passwordHasher,
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        if (!isset($data['email']) || !isset($data['password'])) {
            return $this->json([
                'message' => 'Email and password are required'
            ], Response::HTTP_BAD_REQUEST);
        }

        $email = $usersRepository->emailExists($data['email']);

        if (!$email instanceof Users || !$passwordHasher->isPasswordValid($email, $data['password'])) {
            return $this->json([
                'message' => 'Invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->json([
            'success' => true,
            'token' => $jwtManager->create($email),
        ], 200);
    }
}