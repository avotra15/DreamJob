<?php

namespace App\Controller;

use App\Reponse\ApiReponse;
use App\Service\SearchPageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

final class PagesController extends AbstractController
{

    public function __construct(
        private ApiReponse $apiReponse,
        private SearchPageService $searchPageService    
        )
    {
    }

    #[Route('/pages', name: 'app_pages', methods:['GET'])]
    public function listepages()
    {
        //$chemin = $this->getParameter('/pages');
        
        $Allpages = $this->searchPageService->filesearch();

        if($Allpages == null) {
            return $this->apiReponse->error('Aucun Pages trouvé', 404);
        }

        return $this->apiReponse->sucess($Allpages, 'Pages trouvé');
    }
}
