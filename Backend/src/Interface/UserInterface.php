<?php
namespace App\Interface;

use App\Entity\Users;

interface UserInterface
{
    public function createUser(array $data): Users;
    public function updateUser(Users $user, array $data): Users;
    public function deleteUser(Users $user): void;
}
?>