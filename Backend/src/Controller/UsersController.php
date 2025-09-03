<?php

namespace App\Controller;

use App\Entity\Roles;
use App\Reponse\ApiReponse;
use App\Repository\UsersRepository;
use App\Service\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class UsersController extends AbstractController
{
    private UserInterface $userInterface;
    private UsersRepository $usersRepository;
    private ApiReponse $apiReponse;

    public function __construct(UserInterface $userInterface, UsersRepository $usersRep, ApiReponse $apiReponse) 
    {
        $this->userInterface = $userInterface;
        $this->usersRepository = $usersRep;
        $this->apiReponse = $apiReponse;

    }

    #[Route('/api/users', name: 'users', methods:['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function Users()
    {
        $userss = $this->usersRepository->getAllUsers();
        
        return $this->apiReponse->sucess($userss, 'Listes Utilisateurs');
    }

    #[Route('/api/user/{id}', name: 'app_user_id', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
        public function UserId(int $id) 
        {
            $user = $this->usersRepository->getUserById($id);

        return $this->apiReponse->sucess($users, '');
        }

    #[Route('/registrer', name: 'registrer', methods:['POST'])]
    public function registrer(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $user = $this->userInterface->createUser($data,  new Roles());

        return $this->apiReponse->sucess($user, '');
        $this->redirectToRoute('login');
    } 

    #[Route('/api/update/{id}', name: 'app_user_update', methods: ['PATH'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
        public function updateUser(int $id, Request $request,)
        {
            $user = $this->usersRepository->getUserById($id);

            if (!$user) {
                return $this->apiReponse->error('Utilisateur non trouvé');
            }

            $data = json_decode($request->getContent(), true);
            $user = $this->userInterface->updateUser($user, $data);

            return $this->apiReponse->sucess($user->getId(), 'Utilisateur modifié');
        }

        #[Route('/api/delete/{id}', name: 'app_user_delete', methods: ['DELETE'])] 
        #[IsGranted('IS_AUTHENTICATED_FULLY')]
        public function deleteUser(int $id)
        {
            $user = $this->usersRepository->getUserById($id);

            if (!$user) {
                return $this->json([
                    "failure" => false, 
                    "message" => "Utilisateur non trouvé"], 404);
            }

            $user = $this->userInterface->deleteUser($user);

            return $this->apiReponse->sucess('Utilisateur supprimé');
        }
}
