<?php

namespace App\Controller;

use App\Reponse\ApiReponse;
use App\Service\PageService;
use App\Service\SearchPageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class PagesController extends AbstractController
{

    public function __construct(
        private ApiReponse $apiReponse,
        private SearchPageService $searchPageService,
        private PageService $pageServ
        )
    {
    }


    #[Route('/createpage', name: 'app_create_page', methods:['POST'])]
    public function createPage(Request $request) 
    {
        $newPage = $this->pageServ->create($request);
        if (isset($newPage['error'])) {
            return $this->apiReponse->error($newPage['error'], 400);
        }
        $newPage = json_decode($request->getContent(), true);
        return $this->apiReponse->sucess($newPage, 'Page créée avec succès');
    }


    #[Route('/pages', name: 'app_pages', methods:['GET'])]
    public function listepages()
    {        
        $Allpages = $this->searchPageService->filesearch();

        if($Allpages == null) {
            return $this->apiReponse->error('Aucun Pages trouvé', 404);
        }

        return $this->apiReponse->sucess($Allpages, 'Pages trouvé');
    }

}
