<?php

namespace App\Repository;

use App\Entity\JobDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry; 


/**
 * @extends ServiceEntityRepository<JobDetails>
 */
class JobDetailsRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,)
    {
        parent::__construct($registry, JobDetails::class);
    }

    public function getJobDetailsById(int $id): ?JobDetails
    {
        return $this->find($id);
    }

    public function getAllJobDetails(): array
    {
        return $this->findAll();
    }

    //    /**
    //     * @return JobDetails[] Returns an array of JobDetails objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('j')
    //            ->andWhere('j.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('j.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?JobDetails
    //    {
    //        return $this->createQueryBuilder('j')
    //            ->andWhere('j.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
