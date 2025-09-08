<?php

namespace App\Service;

use App\Interface\PermissionInterface;
use App\Repository\PermissionRepository;
use Doctrine\ORM\EntityManagerInterface;

class PermissionService implements PermissionInterface
{
    private EntityManagerInterface $entityManager;
    private PermissionRepository $permissionRepository;

    public function __construct (
            EntityManagerInterface $entityManager,
            PermissionRepository $permissionRepository,
        )
    {
        $this->entityManager = $entityManager;
        $this->permissionRepository = $permissionRepository;
    }
    public function createPermission(array $data): Permission
    {
        $fonctionPer = new Permission();
        $fonctionPer->setFonction($data['FonctionPer'] ?? '');

        $this->entityManager->persist($fonctionPer);
        $this->entityManager->flush();

        return $fonctionPer;
    }

    public function deletePermission(Permission $Permission): void
    {
        $this->entityManager->remove($fonctionPer);
        $this->entityManager->flush();
    }
}
?>