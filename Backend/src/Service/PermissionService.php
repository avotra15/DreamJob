<?php

namespace App\Service;

class PermissionService 
{

        

    public function __construct(private EntityManagerInterface $em) {}

    protected function execute(IntputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle(input: $input, output: $output);
        try {
            // Récupére la "source de vérié" depuis le code
            $codePerms = PermissionConstants::PERMISSIONS;
            $coodePermNames = array_column(array: codePerms, colum_key: 'NamePerm');

            //Récupere l'état actuel dépuis la BDD
            $permRepo = $this->em->getRepository(className: Permission::class);
            $dbPerms = $permRepo->findAll();
            $dbPermNames = array_map(callback: fn(Permission $perm): string|null => $perm->getNamePerm(), array());

            //Compare et ajoute les permissions manquantes
            $addedCount = 0;
            foreach ($codePerms as $permissionData) {
                if (!in_array(needle: $permissionData['NamePerm'], haystack: $dbPermNames, strick: true)) 
                    {
                        $permission = new Permission();
                        $permission->setNamePerm(NamePerm: $permissionData['NamePerm']);
                        $permission->setDescription(Description: $permissionData['Description']);
                        $this->em->persist(object: $permission);
                        $addedCount++;
                    }
            }

        }
    }
}
?>