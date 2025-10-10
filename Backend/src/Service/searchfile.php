<?php

namespace App\Service;

use Symfony\Component\Finder\Finder;

class SearchPageService
{
    public function __construct() {}

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
}