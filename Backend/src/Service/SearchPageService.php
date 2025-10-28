<?php

namespace App\Service;

use App\Entity\Pages;
use App\Entity\Roles;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;

class SearchPageService
{
    private EntityManagerInterface $em;
    private LoggerInterface $logger;

    public function __construct(
        EntityManagerInterface $em,
        LoggerInterface $logger,

    ) {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function filesearch()
    {
        $finder = new Finder();

        $chemin = dirname(__DIR__);

        $finder->files()->in($chemin . '/Pages');

        $pages = [];
        foreach($finder as $file) {
            $pages[] = [
                'nom' => $file->getFilename(),
                'chemin' => $file->getRealPath(),
                'taille' => $file->getSize(),
                'extension' => $file->getExtension()
            ];
        }
        return $pages;
    }

    /**
     * Recevra les données envoyées par Angular
     */
    public function PageissionPage(Request $req) 
    {
        $data = json_decode($req->getContent(), true);

        $nomPage = $data['pg_nom'] ?? null;
        $idRole = $data['r_id'] ?? null;
        $isChecked = $data['isChecked'] ?? null;
        
        $role = $this->em->getRepository(Roles::class)->find($idRole);
        $page = $this->filesearch();

        if ($isChecked === true) {
            $nomPage->addRole($idRole);
            $role->addRole($page);
        }
    }

        /**
     * Synchronise les Pageissions depuis PageissionConstants vers la base de données
     * 
     * @return array{added: int, updated: int, total: int}
     */
    public function synchronizePages(): array
    {
        $PagePage = $this->em->getRepository(Pages::class);
        
        // Récupère les pages depuis le dossier
        $codePages = $this->filesearch();
        
        // Récupère toutes les Pageissions existantes en base
        $dbPages = $PagePage->findAll();
        $dbPageMap = [];
        
        foreach ($dbPages as $pages) {
            $dbPageMap[$pages->getNamePage()] = $pages;
        }
        
        $addedCount = 0;
        $updatedCount = 0;
        
        foreach ($codePages as $pageData) {
            $namePage = $pageData['nom'];
            $pathPage = $pageData['chemin'];
            
            if (!isset($dbPageMap[$namePage])) {
                // Pageission n'existe pas, on la crée
                $page = new Pages();
                $page->setPage($namePage);
                $page->setPath($pathPage);
                $this->em->persist($page);
                $addedCount++;
                
                $this->logger->info("Page ajoutée : {$namePage}");
            } else {
                // Pageission existe, on met à jour la description si nécessaire
                $existingPage = $dbPageMap[$namePage];
                if ($existingPage->setPath() !== $pathPage) {
                    $existingPage->setPath($pathPage);
                    $updatedCount++;
                    
                    $this->logger->info("Page mise à jour : {$namePage}");
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
            'total' => count($codePages)
        ];
    }
}