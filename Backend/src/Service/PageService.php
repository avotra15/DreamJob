<?php
namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PageService
{
    private Filesystem $filesystem;
    private string $pagesDirectory;

    public function __construct(
    )
    {
        $this->filesystem = new Filesystem();
        $this->pagesDirectory = dirname(__DIR__) . '/Pages';
        
        // Créer le dossier Pages s'il n'existe pas
        if (!$this->filesystem->exists($this->pagesDirectory)) {
            $this->filesystem->mkdir($this->pagesDirectory);
        }
    }

    /**
     * Crée un nouveau fichier page
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $nomPage = $data['nom_page'] ?? null;
        $extension = $data['extension'] ?? 'html';
        $contenu = $data['contenu'] ?? '';

        // Nettoyer le nom du fichier
        $nomPage = $this->sanitizeFilename($nomPage);
        
        // Ajouter l'extension si elle n'est pas déjà présente
        if (!str_ends_with($nomPage, '.' . $extension)) {
            $nomPage .= '.' . $extension;
        }

        $filePath = $this->pagesDirectory . '/' . $nomPage;

        // Vérifier si le fichier existe déjà   
        if ($this->filesystem->exists($filePath)) {
            return ['error' => 'Cette page existe déjà'];
            //throw new \RuntimeException('Cette page existe déjà');
        }
        
        $this->filesystem->dumpFile($filePath, $contenu);

        $this->filesystem->chgrp($filePath, 'www-data');
        $this->filesystem->chmod($filePath, 0664);
    }

    /**
     * Supprime une page
     */
    public function deletePage(string $nomPage): JsonResponse
    {
        $filePath = $this->pagesDirectory . '/' . $nomPage;

        if (!$this->filesystem->exists($filePath)) {
            return new JsonResponse(['error' => 'Page non trouvée'], 404);
        }

        try {
            $this->filesystem->remove($filePath);

            return new JsonResponse([
                'success' => true,
                'message' => 'Page supprimée avec succès'
            ]);

        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Met à jour le contenu d'une page
     */
    public function updatePage(Request $request, string $nomPage): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $contenu = $data['contenu'] ?? '';

        $filePath = $this->pagesDirectory . '/' . $nomPage;

        if (!$this->filesystem->exists($filePath)) {
            return new JsonResponse(['error' => 'Page non trouvée'], 404);
        }

        try {
            $this->filesystem->dumpFile($filePath, $contenu);

            return new JsonResponse([
                'success' => true,
                'message' => 'Page mise à jour avec succès'
            ]);

        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupère le contenu d'une page
     */
    public function getPageContent(string $nomPage): JsonResponse
    {
        $filePath = $this->pagesDirectory . '/' . $nomPage;

        if (!$this->filesystem->exists($filePath)) {
            return new JsonResponse(['error' => 'Page non trouvée'], 404);
        }

        try {
            $contenu = file_get_contents($filePath);

            return new JsonResponse([
                'success' => true,
                'nom_page' => $nomPage,
                'contenu' => $contenu
            ]);

        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => 'Erreur lors de la lecture: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Nettoie le nom du fichier
     */
    private function sanitizeFilename(string $filename): string
    {
        // Supprimer les caractères dangereux
        $filename = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $filename);
        return $filename;
    }

    
}