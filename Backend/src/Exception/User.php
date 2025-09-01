<?php
namespace App\Exception;

use Exception;

class User extends Exception 
{
    public function __construct() 
    {
        parent::__construct("Utilisateur non trouvé.", 404);
    }
}