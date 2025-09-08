<?php
namespace App\Interface;

use App\Entity\Permission;

interface PermissionInterface
{
    public function createPerm(array $data, Permission $permission): Permission;
    public function deletePerm(Permission $permission): void;
}
?>