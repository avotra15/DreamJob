<?php
namespace App\Service;

use App\Entity\JobDetails;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Request;

interface JobServiceInterface
{
    public function createJob(Request $request, Users $user): JobDetails;
    public function updateJob(Jobs $Job, Request $request): JobDetails;
    public function deleteJob(Jobs $Job): void;
}
?>