<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Service\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class UsersController extends AbstractController
{
    /*private UserInterface $userInterface;
    private UsersRepository $usersRepository;*/

    public function __construct(UserInterface $userInterface, UsersRepository $usersRepository) 
    {
        $this->userInterface = $userInterface;
        $this->UsersRepository = $usersRepository;
    }

    #[Route('/api/users', name: 'users', methods:['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function Users()
    {
        $userss = $usersRepository->getAllUsers();
        
        return $reponse->sucess($userss, 'Listes Utilisateurs');
    }

    #[Route('/api/user/{id}', name: 'app_user_id', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
        public function UserId(int $id) 
        {
            $user = $usersRepository->getUserById($id);

            return $this->json([
                'success' => true, $user
            ], 200);
        }

    #[Route('/registrer', name: 'registrer', methods:['POST'])]
    public function createUser()
    {
        $user = $userInterface->createUser($data, $role);

        return $this->json([
                'success' => true, $user
            ]);
        $this->redirectToRoute('login');
    } 

    #[Route('/api/update/{id}', name: 'app_user_update', methods: ['PATH'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
        public function updateUser(int $id, Request $request,)
        {
            $user = $usersRepository->getUserById($id);

            if (!$user) {
                return $this->json([
                    "failure" => false, 
                    "message" => "Utilisateur non trouvé"], 404);
            }

            $data = json_decode($request->getContent(), true);
            $user = $userInterface->updateUser($user, $data);

            return $this->json([
                    "success" => true, 
                    "message" => "Utilisateur modifié",
                    'id' => $user->getId()], 202);
        }

        #[Route('/api/delete/{id}', name: 'app_user_delete', methods: ['DELETE'])] 
        #[IsGranted('IS_AUTHENTICATED_FULLY')]
        public function deleteUser(int $id)
        {
            $user = $userRepository->getUserById($id);

            if (!$user) {
                return $this->json([
                    "failure" => false, 
                    "message" => "Utilisateur non trouvé"], 404);
            }

            $user = $userInterface->deleteUser($user);

            return $this->json([
                    "success" => true, 
                    "message" => "Utilisateur supprimé"], 202);
        }
}
