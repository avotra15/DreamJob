<?php

namespace App\Repository;

use App\Entity\PagePerm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PagePerm>
 */
class PagePermRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PagePerm::class);
    }

    public function getPagePermnById(int $id): ?PagePerm
    {
        return $this->find($id);
    }

    /**
     * Récupère un page par son nom (valeur dans le champ "page")
     */
    public function findByName(array $PagepermName): ?PagePerm
    {
        return $this->findOneBy(['PagepermName' => $PagepermName]);
    }

    //    /**
    //     * @return PagePerm[] Returns an array of PagePerm objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PagePerm
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
