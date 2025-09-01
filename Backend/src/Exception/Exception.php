<?php
namespace App\Exception;

use Exception;

class ApiException extends Exception
{
    private int $statusCode;
    
    public function __construct(
        string $message, 
        int $statusCode)
   {
        parent::__construct($message);
        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
?>