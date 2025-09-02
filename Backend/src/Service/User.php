<?php

namespace App\Service;

use App\Entity\Roles;
use App\Entity\Users;
use App\Service\UserInterface;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class User implements UserInterface
{
    private UserPasswordHasherInterface $userPasswordHasher;
    private EntityManagerInterface $entityManager;

        public function __construct (
            UserPasswordHasherInterface $userPasswordHasher, 
            EntityManagerInterface $entityManager,
            )
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->entityManager = $entityManager;
    }

    public function createUser(array $data, Roles $role) : Users
    {
            $user = new Users();
            $user->setNom($data['Nom'] ?? '');
            $user->setEmail($data['Email'] ?? '');
            $user->setRole($role);

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
       
            
            $hashedPassword = $this->userPasswordHasher->hashPassword($user, $data['Password']);
            $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }


    public function updateUser(Users $user, array $data): Users 
    {
        if (isset($data['Nom'])) {
            $user->setNom($data['Nom'] ?? '');
        }
        if (isset($data['Email'])) {
            $user->setEmail($data['Email']);
        }

        if (!empty($data['Password'])) {
            $hashedPassword = $this->userPasswordHasher->hashPassword($user, $data['Password']);
            $user->setPassword($hashedPassword);
        }

        $this->entityManager->flush();

        return $user;
    }

    public function deleteUser(Users $user): void
    {
        
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
?>