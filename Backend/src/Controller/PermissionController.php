<?php

namespace App\Controller;

use App\Reponse\ApiReponse;
use App\Interface\PermissionInterface;
use App\Repository\PermissionRepository;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class PermissionController extends AbstractController
{
    private PermissionInterface $PermissionInterface;
    private PermissionsRepository $PermissionsRepository;
    private ApiReponse $apiReponse;

    public function __construct(PermissionInterface $permissionInterface, PermissionsRepository $permissionsRep, ApiReponse $apiReponse) 
    {
        $this->PermissionInterface = $permissionInterface;
        $this->PermissionsRepository = $permissionsRep;
        $this->apiReponse = $apiReponse;

    }

    #[Route('/createPerm', name: 'app_permission', methods:['POST'])]
    public function enregistre(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $fonctionPer = $this->PermissionInterface->createPermission($data);
        return $this->apiReponse->sucess($data, 'Permission enregistre avec sucessée');
        //$this->redirectToRoute('login');
    }

    #[Route('/delete/{id}', name: 'app_permission_delete', methods: ['DELETE'])] 
    public function deletePermission(int $id)
    {
        $permission = $this->permissionsRepository->getPermissionById($id);
        if (!$permission) {
             return $this->apiReponse->error('Permission non trouvé', 404, $permission);
        }
        $permission = $this->permissionInterface->deletePermission($permission);
        return $this->apiReponse->sucess($permission, 'Permission supprime');
    }
}
