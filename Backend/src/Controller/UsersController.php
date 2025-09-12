<?php

namespace App\Controller;

use App\Entity\Roles;
use App\Reponse\ApiReponse;
use App\Repository\UsersRepository;
use App\Interface\UserInterface;
use App\Security\Voter\UserVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

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

    #[Route('/api/registrer', name: 'registrer', methods:['POST'])]
    #[IsGranted(UserVoter::CREATE)]
    public function registrer(Request $request)
    {
        //$this->denyAccessUnlessGranted(UserVoter::CREATE);

        $data = json_decode($request->getContent(), true);
        $newUser = $this->userInterface->createUser($data,  new Roles());

        return $this->apiReponse->sucess($newUser, 'Utilisateur enregistre avec sucessée');
        $this->redirectToRoute('login');
    } 

    #[Route('/api/updateUser/{id}', name: 'app_user_update', methods: ['PATH'])]
        public function updateUser(int $id, Request $request,)
        {
            $user = $this->usersRepository->getUserById($id);

            $this->denyAccessUnlessGranted('EDIT', $user);

            if (!$user) {
                return $this->apiReponse->error('Utilisateur non trouvé');
            }

            $data = json_decode($request->getContent(), true);
            $user = $this->userInterface->updateUser($user, $data);

            return $this->apiReponse->sucess($user->getId(), 'Utilisateur modifié');
        }

        #[Route('/api/delete/{id}', name: 'app_user_delete', methods: ['DELETE'])] 
        public function deleteUser(int $id)
        {
            $user = $this->usersRepository->getUserById($id);
            $this->denyAccessUnlessGranted('DELETE', $user);
            if (!$user) {
                 return $this->apiReponse->error('Utilisateur non trouvé', 404, $user);
            }
            $user = $this->userInterface->deleteUser($user);
            return $this->apiReponse->sucess($user, 'Utilisateur supprime');
        }

        #[Route('/api/users', name: 'users', methods:['GET'])]
        public function Users()
        {
            $this->denyAccessUnlessGranted('Admin');
            
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

        #[Route('/user/{id}', name: 'app_user_id', methods: ['GET'])]
            public function UserId(int $id) 
            {
                $user = $this->usersRepository->getUserById($id);

                $this->denyAccessUnlessGranted('VIEW', $user);

                if(!$user) {
                    return $this->apiReponse->error('Utilisateur non trouvé', 404, $user);
                }
                return $this->apiReponse->sucess($user, 'Utilisateur trouvé');
            }

}
