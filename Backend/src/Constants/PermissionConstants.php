<?php

namespace App\Constants;

/**
 * Classe centralisant toutes les permissions de l'application
 * Basée sur les permissions définies dans le configuration
 */
class PermissionConstants
{
    
    // Permissions individuelles - Gestion des Utilisateurs
    public const USER_LIST = 'user.list';
    public const USER_CREATE = 'user.create';


    // Catégories de permissions
    public const CATEGORY_USER = 'user';

    // Groupes de permissions prédéfinies
    public const PERMISSION_GROUPS = [
        'ROLE_ADMIN' => [
            self::USER_LIST,
            self::USER_CREATE,
        ],

        'ROLE_CANDIDAT' => [
            self::USER_CREATE,
        ],
    ];
    
    public const PERMISSIONS = [
         self::USER_LIST => [
            'name' => self::USER_LIST,'description' => 'Voir la liste de tous les utilisateurs','category' => self::CATEGORY_USER
        ],
    ];

    /**
     * Récupérer toutes les permissions disponibles
     */
    public static function getAllPermissions(): array
    {
        return self::PERMISSIONS;
    }

}
?>