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
<<<<<<< HEAD
        private ApiReponse $apiReponse,
        private Request $req,
        private EntityManager $em,
=======
        private ApiReponse $apiReponse,        
>>>>>>> 78ae9662abba50f58e83673d496dbaf7dc8a1e65
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

<<<<<<< HEAD
    #[Route('/permission/checked', name: 'checke_permission', methods: ['POST'])]
    public function checkPermissiom() {

    }
    
=======
     #[Route('/checkedPermission', name: 'checked_permissions', methods: ['POST'])]
     public function checkedPermission() {
        $checked = $this->PermissionService->permissionRole();
        return $this->apiReponse->sucess($checked, 'Relation mise à jour avec succès');
     }

>>>>>>> 78ae9662abba50f58e83673d496dbaf7dc8a1e65
}