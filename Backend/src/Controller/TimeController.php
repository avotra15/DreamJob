<?php

namespace App\Controller;

use App\Repository\TimeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class TimeController extends AbstractController
{
    #[Route('/time', name: 'app_time', methods: ['GET'])]
    public function getTime(
        TimeRepository $timeRep,
    ): JsonResponse
    {
        $times = $timeRep->getAllTime();

        $data = array_map(fn($time) => [
            'id' => $time->getId(),
            'duration' => $time->getDuration()
        ], $times);

         return $this->json($data);
    }
}
