<?php
namespace App\Exception;

use Exception;

class Email extends Exception 
{
    public function __construct() 
    {
        parent::__construct("Email déjà utilisé", 404);
    }
}