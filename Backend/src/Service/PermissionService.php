<?php

namespace App\Service;

use App\Entity\Permission;
use App\Entity\Roles;
use App\Constants\PermissionConstants;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class PermissionService
{
    private EntityManagerInterface $em;
    private LoggerInterface $logger;
    private Request $req;

        public function __construct(
            EntityManagerInterface $em,
            LoggerInterface $logger,  
        ) 
        {
            $this->em = $em;
            $this->logger = $logger;
        }

    /**
     * Synchronise les permissions depuis PermissionConstants vers la base de données
     * 
     * @return array{added: int, updated: int, total: int}
     */
    public function synchronizePermissions(): array
    {
        $permRepo = $this->em->getRepository(Permission::class);
        
        // Récupère les permissions depuis la constante
        $codePerms = PermissionConstants::PERMISSIONS;
        
        // Récupère toutes les permissions existantes en base
        $dbPerms = $permRepo->findAll();
        $dbPermsMap = [];
        
        foreach ($dbPerms as $perm) {
            $dbPermsMap[$perm->getNamePerm()] = $perm;
        }
        
        $addedCount = 0;
        $updatedCount = 0;
        
        foreach ($codePerms as $permData) {
            $namePerm = $permData['NamePerm'];
            $description = $permData['Description'];
            
            if (!isset($dbPermsMap[$namePerm])) {
                // Permission n'existe pas, on la crée
                $permission = new Permission();
                $permission->setNamePerm($namePerm);
                $permission->setDescription($description);
                $this->em->persist($permission);
                $addedCount++;
                
                $this->logger->info("Permission ajoutée : {$namePerm}");
            } else {
                // Permission existe, on met à jour la description si nécessaire
                $existingPerm = $dbPermsMap[$namePerm];
                if ($existingPerm->getDescription() !== $description) {
                    $existingPerm->setDescription($description);
                    $updatedCount++;
                    
                    $this->logger->info("Permission mise à jour : {$namePerm}");
                }
            }
        }
        
        // Sauvegarde en base de données
        if ($addedCount > 0 || $updatedCount > 0) {
            $this->em->flush();
        }
        
        return [
            'added' => $addedCount,
            'updated' => $updatedCount,
            'total' => count($codePerms)
        ];
    }

    /**
     * Recevra les données envoyées par Angular
     */
    public function permissionRole(Request $req) 
    {
        $data = json_decode($this->req->getContent(), true);

        $idPerm = $data['p_id'] ?? null;
        $idRole = $data['r_id'] ?? null;
        $isChecked = $data['isChecked'] ?? null;

        $perm = $this->em->getRepository(Permission::class)->find($idPerm);
        $role = $this->em->getRepository(Roles::class)->find($idRole);

        if ($isChecked === true) {
            $perm->addRole($idRole);
            $role->addRole($idPerm);
        }

        $this->em->persist($perm);
        $this->em->flush();
    }
    
    /**
     * Vérifie si une permission existe par son nom
     */
    public function permissionExists(string $namePerm): bool
    {
        $permRepo = $this->em->getRepository(Permission::class);
        $permission = $permRepo->findOneBy(['namePerm' => $namePerm]);
        
        return $permission !== null;
    }
    
    /**
     * Récupère une permission par son nom
     */
    public function getPermissionByName(string $namePerm): ?Permission
    {
        $permRepo = $this->em->getRepository(Permission::class);
        return $permRepo->findOneBy(['namePerm' => $namePerm]);
    }
}