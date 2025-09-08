<?php
namespace App\Interface;

use App\Entity\Permission;

interface PermissionInterface
{
    public function createPermission(array $data): Permission;
    public function deletePermission(Permission $Permission): void;
}
?>