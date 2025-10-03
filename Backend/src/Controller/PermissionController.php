<?php

namespace App\Controller;

use App\Constants\PermissionConstants;
use App\Reponse\ApiReponse;
use App\Repository\PermissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

final class PermissionController extends AbstractController
{


    public function __construct(
        private PermissionRepository $permRepo,
        private ApiReponse $apiReponse,        
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
        
        //return $this->json($data);
        return $this->apiReponse->sucess($data, 'Permission trouvé');
    }

     #[Route('/checkedPermission', name: 'checked_permissions', methods: ['POST'])]
     public function checkedPermission() {
        $checked = $this->PermissionService->permissionRole();
        return $this->apiReponse->sucess($checked, 'Relation mise à jour avec succès');
     }

}