<?php

namespace App\Controller;

use App\Entity\Roles;
use App\Reponse\ApiReponse;
use App\Repository\UsersRepository;
use App\Interface\UserInterface;
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

    #[Route('/registrer', name: 'registrer', methods:['POST'])]
    public function registrer(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $user = $this->userInterface->createUser($data,  new Roles());

        return $this->apiReponse->sucess($data, 'Utilisateur enregistre avec sucessée');
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
                 return $this->apiReponse->error('Utilisateur non trouvé', 404, $user);
            }

            $user = $this->userInterface->deleteUser($user);

            return $this->apiReponse->sucess($user, 'Utilisateur supprime');
        }

        #[Route('/users', name: 'users', methods:['GET'])]
        //#[IsGranted('IS_AUTHENTICATED_FULLY')]
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

        #[Route('/user/{id}', name: 'app_user_id', methods: ['GET'])]
        //#[IsGranted('IS_AUTHENTICATED_FULLY')]
            public function UserId(int $id) 
            {
                $user = $this->usersRepository->getUserById($id);

                if(!$user) {
                    return $this->apiReponse->error('Utilisateur non trouvé', 404, $user);
                }
                return $this->apiReponse->sucess($user, 'Utilisateur trouvé');
            }

}
