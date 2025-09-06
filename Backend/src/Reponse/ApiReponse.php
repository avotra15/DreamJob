<?php
namespace App\Reponse;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiReponse extends JsonResponse
{
    public function sucess($data = null || [], string $message, int $code = 200 ): JsonResponse
    {
        return new JsonResponse([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

     public function error(string $message, int $code = 400, $details = null): JsonResponse
    {
        return new JsonResponse([
            'status' => 'error',
            'error' => [
                'code' => $code,
                'message' => $message,
                'details' => $details
            ]
        ], $code);
    }
}
?>