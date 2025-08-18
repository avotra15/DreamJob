<?php

namespace App\Service;

use App\Entity\Roles;
use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService implements UserServiceInterface
{
    private UserPasswordHasherInterface $userPasswordHasher;
    private EntityManagerInterface $entityManager;
    private UsersRepository $usersRepository;

        public function __construct (
            UserPasswordHasherInterface $userPasswordHasher, 
            EntityManagerInterface $entityManager,
            UsersRepository $usersRepository,
            )
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->entityManager = $entityManager;
        $this->usersRepository = $usersRepository;
    }

    public function createUser(array $data, Roles $role) : Users 
    {
            $user = new Users();
            $user->setNom($data['Nom'] ?? '');
            $user->setEmail($data['Email'] ?? '');
            $user->setRole($role);
            
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