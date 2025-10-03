<?php

namespace App\Controller;

use App\Reponse\ApiReponse;
use App\Repository\PermissionRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Routing\Attribute\Route;

final class PermissionController extends AbstractController
{


    public function __construct(
        private PermissionRepository $permRepo,
        private ApiReponse $apiReponse,
        private Request $req,
        private EntityManager $em,
    )
    {
    }

    #[Route('/voirpermission', name: 'voir_permissions', methods: ['GET'])]
    public function voirpermission()
    {        
        $Allpermission = $this->permRepo->getAllPermission();

        $data = array_map(fn($Allpermission) => [
            'id' => $Allpermission->getId(),
            'nom' => $Allpermission->getNamePerm(),
            'description' => $Allpermission->getDescription(),
        ], $Allpermission);

        return $this->apiReponse->sucess($data, 'Permission trouvé');
    }

    #[Route('/permission/checked', name: 'checke_permission', methods: ['POST'])]
    public function checkPermissiom() {

    }
    
}