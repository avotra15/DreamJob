<?php

namespace App\Repository;

use App\Entity\JobDetails;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<JobDetails>
 */
class JobDetailsRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, JobDetails::class);
        $this->entityManager = $entityManager;
    }


    public function createFromRequest(Request $request, Users $user): JobDetails
     {
            $titre = $request->request->get('titre');
            $description = $request->request->get('description');
            $fichierFile = $request->files->get('fichierFile');
            $logoFile = $request->files->get('logoFile');

            $jobdetails = new JobDetails();
            
            $jobdetails->setTitre($titre);
            $jobdetails->setDescription($description);
            $jobdetails->setFichierFile($fichierFile);
            $jobdetails->setLogoFile($logoFile);
            $jobdetails->setEmail($user);

            $this->entityManager->persist($jobdetails);
            $this->entityManager->flush();

            return $jobdetails;

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
