<?php
namespace App\Interface;

use App\Entity\JobDetails;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Request;

interface JobInterface
{
    public function createJob(Request $request, Users $user): JobDetails;
    public function deleteJob(JobDetails $Job): void;
}
?>