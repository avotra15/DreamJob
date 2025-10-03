<?php

namespace App\Service;

use App\Entity\Permission;
use App\Constants\PermissionConstants;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class PermissionService
{
    public function __construct(
        private EntityManagerInterface $em,
        private LoggerInterface $logger
    ) {}

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