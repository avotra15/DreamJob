<?php

namespace App\Controller;

<<<<<<< HEAD
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
=======
use App\Entity\Permission;
use App\Interface\PermissionInterface;
use App\Reponse\ApiReponse;
use App\Repository\PermissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class PermissionController extends AbstractController
{
    private PermissionInterface $permissionInterface;
    private PermissionRepository $permissionRepository;
    private ApiReponse $apiReponse;

    public function __construct(PermissionInterface $permissionInterface, PermissionRepository $permissionRepository, ApiReponse $apiReponse)
    {
        $this->permissionInterface = $permissionInterface;
        $this->permissionRepository = $permissionRepository;
        $this->apiReponse = $apiReponse;
    }
    #[Route('/createpermission', name: 'create_permission', methods:['POST'])]
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $this->permissionInterface->createPerm($data, new Permission);

>>>>>>> b2bd723822cbb9a3c0e4a9127b8fbfe44476e718
        return $this->apiReponse->sucess($data, 'Permission enregistre avec sucessée');
        //$this->redirectToRoute('login');
    }

<<<<<<< HEAD
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
=======
    #[Route('/deleteperm/{id}', name: 'app_delete_permission', methods:['DELETE'])]
    public function delete(int $id)
    {
        $permission = $this->permissionRepository->getPermissionById($id);

        if (!$permission){
             return $this->apiReponse->error('Permission non trouvé', 404, $permission);
        }

         $permission = $this->permissionInterface->deletePerm($permission);

            return $this->apiReponse->sucess($permission, 'Permission supprime');
    }

    #[Route('/permissions', name: 'permissions', methods:['GET'])]
     public function permissions()
     {
        $permission = $this->permissionRepository->getAllPermission();

        $data = array_map(function($perm) {
                return [
                    'ig' => $perm->getId(),
                    'nomPerm' => $perm->getNamePerm(),
                ];
            }, $permission);

        return $this->apiReponse->sucess($data, 'Listes Permissions');
     }
>>>>>>> b2bd723822cbb9a3c0e4a9127b8fbfe44476e718
}
