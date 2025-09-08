<?php

namespace App\Service;

use App\Entity\Permission;
use App\Interface\PermissionInterface;
use Doctrine\ORM\EntityManagerInterface;

class PermissionService implements PermissionInterface 
{
    private EntityManagerInterface $em;
    
    public function __construct(
        EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createPerm(array $data, Permission $permission): Permission 
    {
        
            $permission = new Permission();

            $permission->setNamePerm($data['Perm']);

            $this->em->persist($permission);
            $this->em->flush();

            return $permission;
    }

    public function deletePerm(Permission $permission): void
    {
        $this->em->remove($permission);
        $this->em->flush();
    }
}

?>