<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\RolesRepository;
use App\Repository\UsersRepository;
use App\Service\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class UsersController extends AbstractController
{
    private UserServiceInterface $userServiceInterface;

    public function __construct(UserServiceInterface $userServiceInterface) 
    {
        $this->userServiceInterface = $userServiceInterface;
    }
    #[Route('/api/users', name: 'users', methods:['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function Users(
        UsersRepository $usersRepository,
        ): JsonResponse
    {
        $userss = $usersRepository->getAllUsers();

        $dataUsers = array_map(fn($users) => [
            'id' => $users->getId(),
            'nom' => $users->getNom(),
            'roles' => $users->getRoles(),
            'email' => $users->getEmail()
        ], $userss);

         return $this->json($dataUsers);
    }

    #[Route('/api/user/{id}', name: 'app_user_id', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
        public function UserId(
            int $id,
            UsersRepository $usersRepository,
        ): JsonResponse {
            $user = $usersRepository->getUserById($id);

            if (!$user) {
                return $this->json([
                    'success' => false,
                    'message' => 'Utilisateur non trouvé.'
                ], 404);
            }

            return $this->json([
                'success' => true,
                'user' => [
                    'id' => $user->getId(),
                    'nom' => $user->getNom(),
                    'email' => $user->getEmail(),
                    'roles' => $user->getRoles(),
                ]
            ]);
        }

    #[Route('/registrer', name: 'registrer', methods:['POST'])]
    public function createUser(
        Request $request,
        UsersRepository $usersRepository,
        UserServiceInterface $userServiceInterface,
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
       
        $user = $userServiceInterface->createUser($data, $role);

            return $this->json([
                'success' => true,
                'messages' => 'User créer avec succès',
                'id' => $user->getId(),
            ], 200);
            $this->redirectToRoute('login');
            } 

        #[Route('/api/update/{id}', name: 'app_user_update', methods: ['PATH'])]
        #[IsGranted('IS_AUTHENTICATED_FULLY')]
        public function updateUser(
            int $id,
            Request $request,
            UserServiceInterface $userServiceInterface
        ): JsonResponse
        {
            $user = $usersRepository->getUserById($id);

            if (!$user) {
                return $this->json([
                    "failure" => false, 
                    "message" => "Utilisateur non trouvé"], 404);
            }

            $data = json_decode($request->getContent(), true);
            $user = $userServiceInterface->updateUser($user, $data);

            return $this->json([
                    "success" => true, 
                    "message" => "Utilisateur modifié",
                    'id' => $user->getId()], 202);
        }

        #[Route('/api/delete/{id}', name: 'app_user_delete', methods: ['DELETE'])] 
        #[IsGranted('IS_AUTHENTICATED_FULLY')]
        public function deleteUser(
            int $id,
            UsersRepository $userRepository,
            UserServiceInterface $userServiceInterface,
        ): JsonResponse
        {
            $user = $userRepository->getUserById($id);

            if (!$user) {
                return $this->json([
                    "failure" => false, 
                    "message" => "Utilisateur non trouvé"], 404);
            }

            $user = $userServiceInterface->deleteUser($user);

            return $this->json([
                    "success" => true, 
                    "message" => "Utilisateur supprimé"], 202);
        }
}
