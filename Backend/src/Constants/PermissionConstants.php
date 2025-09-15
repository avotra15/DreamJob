<?php

namespace App\Constants;

/**
 * Classe centralisant toutes les permissions de l'application
 * Basée sur les permissions définies dans le configuration
 */
class PermissionConstants
{
    public const PERMISSIONS = [
         self::USER_LIST => [
            'name' => self::USER_LIST,
            'description' => 'Voir la liste de tous les utilisateurs',
            'category' => self::CATEGORY_USER
        ],

    ];

    // Permissions individuelles - Gestion des Utilisateurs
    public const USER_LIST = 'user.list';

    // Catégories de permissions
    public const CATEGORY_USER = 'user';

        // Groupes de permissions prédéfinies
    public const PERMISSION_GROUPS = [
        'ADMIN' => [
            self::USER_LIST,
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