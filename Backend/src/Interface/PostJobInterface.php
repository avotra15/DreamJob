<?php
namespace App\Interface;

use App\Entity\CV;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Request;

interface PostJobInterface {
    public function postjob(Request $req, Users $user): CV;
}