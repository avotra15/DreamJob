<?php
namespace App\Service;

use App\Entity\Roles;
use App\Entity\Users;

interface UserServiceInterface
{
    public function createUser(array $data, Roles $roles): Users;
    public function updateUser(Users $user, array $data): Users;
    public function deleteUser(Users $user): void;
}
?>