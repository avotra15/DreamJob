<?php

namespace App\Command;

use App\Service\PermissionService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:sync-permissions',
    description: 'Synchronise les permissions depuis PermissionConstants vers la base de données'
)]
class SyncPermissionsCommand extends Command
{
    public function __construct(private PermissionService $permissionService)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $io->title('Synchronisation des permissions');
        
        try {
            $result = $this->permissionService->synchronizePermissions();
            
            $io->success('Synchronisation terminée avec succès !');
            $io->table(
                ['Statut', 'Nombre'],
                [
                    ['Permissions ajoutées', $result['added']],
                    ['Permissions mises à jour', $result['updated']],
                    ['Total dans PermissionConstants', $result['total']]
                ]
            );
            
            if ($result['added'] === 0 && $result['updated'] === 0) {
                $io->info('La base de données est déjà à jour.');
            }
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $io->error('Erreur lors de la synchronisation : ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}