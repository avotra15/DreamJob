<?php

namespace App\Constants;

/**
 * Classe centralisant toutes les permissions de l'application
 * Basée sur les permissions définies dans le configuration
 */
class PermissionConstants
{  
    public const PERMISSIONS = [
        ['NamePerm' => 'user.list','Description' => 'Voir la liste de tous les utilisateurs'],
        ['NamePerm' => 'user.creat','Description' => 'Créer un nouvelle utilisateur interne'],
    ];
    /*
    public static function getAllPermissions(): array
    {
        return self::PERMISSIONS;
    }
    */
}
?>