<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
//use Symfony\Component\Security\Http\Attribute\IsGranted;

class RegistrerController extends AbstractController
{
    /**
     * Reçoit le JSON envoyé par Angular :
     * { "Nom": "...", "Email": "...", "Roles": ["..."], "Password": "..." }
     *
     * Réservé aux administrateurs : les rôles sont choisis par le client.
     * Si l'inscription doit être publique, retirez IsGranted ET ignorez "Roles".
     */
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
        public function register(Request $request, UserService $userService): JsonResponse
        {
            $data = json_decode($request->getContent(), true);

            if (!is_array($data)) {
                return $this->json(['error' => 'JSON invalide.'], Response::HTTP_BAD_REQUEST);
            }

            $nom      = $data['Nom'] ?? $data['nom'] ?? null;
            $email    = $data['Email'] ?? $data['email'] ?? null;
            $password = $data['Password'] ?? $data['password'] ?? null;
            $roles    = $data['Roles'] ?? $data['roles'] ?? [];

            if (!$nom || !$email || !$password) {
                return $this->json(
                    ['error' => 'Les champs Nom, Email et Password sont obligatoires.'],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $roles = array_values(array_filter(
                (array) $roles,
                fn ($r) => is_string($r) && $r !== ''
            ));

            try {
                // On transmet les données NORMALISÉES, pas le tableau brut.
                $user = $userService->createUser([
                    'nom'      => $nom,
                    'email'    => $email,
                    'password' => $password,
                    'roles'    => $roles,
                ]);
            } catch (\DomainException $e) {
                return $this->json(['error' => $e->getMessage()], Response::HTTP_CONFLICT);
            } catch (\InvalidArgumentException $e) {
                return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
            }

            return $this->json([
                'id'    => $user->getId(),
                'nom'   => $user->getNom(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles(),
            ], Response::HTTP_CREATED);
        }
}