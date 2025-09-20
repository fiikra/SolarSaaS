<?php

namespace App\Core;

class Auth
{
    public static function hasPermission($permission)
    {
        if (empty($_SESSION['user_permissions'])) {
            return false;
        }
        return in_array($permission, $_SESSION['user_permissions']);
    }

    public static function check($allowedRoles)
    {
        if (!is_array($allowedRoles)) {
            $allowedRoles = [$allowedRoles];
        }

        if (empty($_SESSION['user_role'])) {
            return false; // No role in session, definitely unauthorized
        }

        // Convert both the user's role and the allowed roles to lowercase for case-insensitive comparison
        $userRoleLower = strtolower($_SESSION['user_role']);
        $allowedRolesLower = array_map('strtolower', $allowedRoles);

        if (!in_array($userRoleLower, $allowedRolesLower)) {
            return false; // User role not in allowed roles
        }
        return true; // User has an allowed role
    }
}
