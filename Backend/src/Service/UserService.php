<?php

namespace App\Service;

use App\Entity\Roles;
use App\Entity\Users;
use App\Interface\UserInterface as InterfaceUserInterface;
use App\Repository\RolesRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService implements InterfaceUserInterface
{
    private UserPasswordHasherInterface $userPasswordHasher;
    private EntityManagerInterface $entityManager;
    private UsersRepository $usersRepository;
    private RolesRepository $rolesRepository;

        public function __construct (
            UserPasswordHasherInterface $userPasswordHasher, 
            EntityManagerInterface $entityManager,
            UsersRepository $usersRepository,
            RolesRepository $rolesRepository,
            )
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->entityManager = $entityManager;
        $this->usersRepository = $usersRepository;
        $this->rolesRepository = $rolesRepository;
    }

    public function createUser(array $data, Roles $role) : Users
    {
            $user = new Users();
            $user->setNom($data['Nom'] ?? '');
            $user->setEmail($data['Email'] ?? '');
            

            $email = $data['Email'] ?? null;
            if (!$email || $this->usersRepository->emailExists($email)) {
                throw new \InvalidArgumentException("Email déjà utilisé ou invalide");
            }

            $roleName = $data['Roles'];
            $roleEntity = $this->rolesRepository->findByName($roleName);
            if (!$roleEntity) {
                throw new \InvalidArgumentException("Rôle invalide");
            }
            $user->setRole($roleEntity);
       
            
            $hashedPassword = $this->userPasswordHasher->hashPassword($user, $data['Password']);
            $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
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