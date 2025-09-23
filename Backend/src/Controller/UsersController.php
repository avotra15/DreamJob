<?php

namespace App\Controller;

use App\Constants\PermissionConstants;
use App\Entity\Roles;
use App\Entity\Users;
use App\Reponse\ApiReponse;
use App\Repository\UsersRepository;
use App\Interface\UserInterface;
use App\Security\Voter\UserVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class UsersController extends AbstractController
{
    public function __construct(    
        private UserInterface $userInterface,
        private UsersRepository $usersRepository,
        private ApiReponse $apiReponse,
        ) 
    {
    }

    #[Route('/api/register', name: 'register', methods:['POST'])]
    #[IsGranted(PermissionConstants::USER_CREATE)]
    public function registrer(Request $request)
    {

        $data = json_decode($request->getContent(), true);
        $newUser = $this->userInterface->createUser($data);

        return $this->apiReponse->sucess($newUser, 'Utilisateur enregistre avec sucessée');
    } 

    #[Route('/api/updateUser/{id}', name: 'app_user_update', methods: ['PATCH'])]
        public function updateUser(int $id, Request $request,)
        {
            $user = $this->usersRepository->getUserById($id);

            if (!$user) {
                return $this->apiReponse->error('Utilisateur non trouvé', 404);
            }

            $data = json_decode($request->getContent(), true);
            $user = $this->userInterface->updateUser($user, $data);

            return $this->apiReponse->sucess($user->getId(), 'Utilisateur modifié');
        }

        #[Route('/api/delete/{id}', name: 'app_user_delete', methods: ['DELETE'])] 
        public function deleteUser(int $id)
        {
            $user = $this->usersRepository->getUserById($id);

            if (!$user) {
                 return $this->apiReponse->error('Utilisateur non trouvé', 404);
            }
            
            $user = $this->userInterface->deleteUser($user);
            return $this->apiReponse->sucess($user, 'Utilisateur supprime');
        }

        #[Route('/api/users', name: 'users', methods:['GET'])]
        #[IsGranted(PermissionConstants::USER_LIST)]
        public function Users()
        {      
            $userss = $this->usersRepository->getAllUsers();

            $userArray = array_map(function($user) {
                return [
                    'id'    => $user->getId(),
                    'email' => $user->getEmail(),
                    'nom'   => $user->getNom(),
                    'role' => $user->getRoles(),
                ];
            }, $userss); 
            
            return $this->apiReponse->sucess($userArray, 'Listes Utilisateurs');
        }

        #[Route('/api/user/{id}', name: 'app_user_id', methods: ['GET'])]
            public function UserId(int $id) 
            {
                $user = $this->usersRepository->getUserById($id);

                if(!$user) {
                    return $this->apiReponse->error('Utilisateur non trouvé', 404);
                }

                return $this->apiReponse->sucess($user, 'Utilisateur trouvé');
            }

}
