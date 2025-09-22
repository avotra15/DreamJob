<?php

namespace App\Controller;

use App\Constants\PermissionConstants;
use App\Reponse\ApiReponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

final class PermissionController extends AbstractController
{


    public function __construct(
        private PermissionConstants $permissionConstants,
        private ApiReponse $apiReponse,
    )
    {
    }

     #[Route('/voirpermission', name: 'voir_permissions', methods: ['GET'])]
    public function voirpermission()
    {        
        $Allpermission = $this->permissionConstants->getAllPermissions();

        return $this->apiReponse->sucess($Allpermission, 'Permission trouvé');
    }
    
}