<?php

namespace App\Repository;

use App\Entity\Roles;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @extends ServiceEntityRepository<Users>
 */
class UsersRepository extends ServiceEntityRepository
{
    private UserPasswordHasherInterface $userPasswordHasher;
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Users::class);
        $this->userPasswordHasher = $userPasswordHasher;
        $this->entityManager = $entityManager;
    }

    public function emailExists(string $email): bool 
    {
        return(bool) $this->findOneBy(['email' => $email]);
    }

    public function createUser(array $data, Roles $roles) : Users 
    {
            $user = new Users();
            $user->setNom($data['Nom'] ?? '');
            $user->setEmail($data['Email'] ?? '');
            $user->setRole($roles);
            
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

        if (isset($data['Password'])) {
            $hashedPassword = $this->userPasswordHasher->hashPassword($user, $data['Password']);
            $user->setPassword($hashedPassword);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

        public function deleteUser(Users $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    //    /**
    //     * @return Users[] Returns an array of Users objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Users
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
