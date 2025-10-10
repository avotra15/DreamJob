<?php

namespace App\Controller;

use App\Reponse\ApiReponse;
use App\Repository\PermissionRepository;
use App\Service\PermissionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

final class PermissionController extends AbstractController
{
    public function __construct(
        private PermissionRepository $permRepo,
        private ApiReponse $apiReponse,
        private PermissionService $permServ    
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

    #[Route('/permission/checked', name: 'checked_permissions', methods: ['POST'])]
    public function permissionChecked() {
        $checked = $this->permServ->permissionRole();
        return $this->apiReponse->sucess($checked, 'Permission trouvé');
    }

}