<?php
namespace App\Service;

use App\Repository\RolesRepository;
use App\Service\PageService;
use App\Service\SearchPageService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FilesystemService
{
    //private static ?string $lastError = null;

    public function __construct(
        private PageService $pgSrv,
        private SearchPageService $srchPSrv,
        private EntityManagerInterface $em,
        private RolesRepository $rolesRepo
    )
    {}

    public function chgrp(?iterable $files = null, string|int $group, bool $recursive = false): void
    {
        $files = $this->srchPSrv->filesearch();

        $filespath = array_column($files, 'chemin');

        foreach ($filespath as $file) {
            if ($recursive && is_dir($file) && !is_link($file)) {
                $this->chgrp(new \FilesystemIterator($file), $group, true);
            }
            if (is_link($file) && \function_exists('lchgrp')) {
                if (!lchgrp($file, $group)) {
                    throw new Exception("Failed to change group");
                }
            } else {
                 if (!chgrp($file, $group)) {
                    throw new Exception("Failed to change group");
                }
            }
        }
    }
    public function updatePermission(Request $req)
    {
        $data = json_decode($req->getContent(), true);

        // Créer le fichier s'il n'existe pas
        $jsonPath = dirname(__DIR__, 1) . '/Security/Filepermission.json';
        if (!file_exists($jsonPath)) {
            file_put_contents($jsonPath, json_encode([], JSON_PRETTY_PRINT));
        }

        $filename = $data['nom_page'] ?? null;
        $idRole = $data['role_id'] ?? null;
        $isChecked = $data['action'] ?? null;

        // ✅ Vérifier que le rôle existe
        $role = $this->rolesRepo->find($idRole);
        if (!$role) {
            return new JsonResponse(['error' => 'Rôle introuvable'], 404);
        }

        // ✅ Vérifier que la page existe - CORRECTION ICI
        $files = $this->srchPSrv->filesearch();
        $pageExists = false;
        foreach ($files as $file) {
            if ($file['nom'] === $filename) {
                $pageExists = true;
                break;
            }
        }

        if (!$pageExists) {
            return new JsonResponse(['error' => 'Page introuvable'], 404);
        }

            // Charger le contenu actuel du fichier JSON
            $permissions = json_decode(file_get_contents($jsonPath), true);
            if (!is_array($permissions)) {
                $permissions = [];
            }

        // Initialiser si non présent
            if (!isset($permissions[$filename])) {
                $permissions[$filename] = [];
            }

            // Ajouter ou retirer le rôle
            if ($isChecked) {
                if (!in_array($idRole, $permissions[$filename])) {
                    $permissions[$filename][] = $idRole;
                }
            } else {
                $permissions[$filename] = array_values(array_diff($permissions[$filename], [$idRole]));
            }

            // ✅ Sauvegarder les permissions mises à jour
            if (file_put_contents($jsonPath, json_encode($permissions, JSON_PRETTY_PRINT)) === false) {
                    return new JsonResponse(['error' => 'Erreur d\'écriture du fichier'], 500);
                }
        } 
}