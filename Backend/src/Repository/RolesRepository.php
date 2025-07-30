<?php

namespace App\Repository;

use App\Entity\Roles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Roles>
 */
class RolesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Roles::class);
    }

    /**
     * Récupère un rôle par son nom (valeur dans le champ "roles")
     */
    public function findByName(array $roleName): ?Roles
    {
        return $this->findOneBy(['roles' => $roleName]);
    }

    
    /**
     * Vérifie si un rôle existe
     */

    public function exists(string $roleName): bool
    {
        return (bool) $this->findOneBy(['Roles' => $roleName]);
    }
    
    
    
    
    //    /**
    //     * @return Roles[] Returns an array of Roles objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Roles
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
