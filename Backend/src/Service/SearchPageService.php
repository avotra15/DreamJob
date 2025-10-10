<?php

namespace App\Service;

use App\Entity\Roles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;

class SearchPageService
{
    private EntityManagerInterface $em;

    public function __construct(
        EntityManagerInterface $em,
    ) {
        $this->em = $em;
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
    public function permissionPage(Request $req) 
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
}