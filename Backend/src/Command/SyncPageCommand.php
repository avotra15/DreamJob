<?php
namespace App\Command;

use App\Service\SearchPageService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:sync-page',
    description: 'Synchronise les pages depuis Dossier Pages vers la base de données'
)]
class SyncPageCommand extends Command
{
    public function __construct(private SearchPageService $searchPageService)
    {
        parent::__construct();
    }

        protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $io->title('Synchronisation des pages');
        
        try {
            $result = $this->searchPageService->synchronizePages();
            
            $io->success('Synchronisation terminée avec succès !');
            $io->table(
                ['Statut', 'Nombre'],
                [
                    ['Pages ajoutées', $result['added']],
                    ['Pages mises à jour', $result['updated']],
                    ['Total dans Pages', $result['total']]
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