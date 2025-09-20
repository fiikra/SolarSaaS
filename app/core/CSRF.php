<?php

namespace App\Core;

class CSRF {
    public static function generateToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyToken($token) {
        if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
            // Token is valid, unset it to prevent reuse
            unset($_SESSION['csrf_token']);
            return true;
        }
        return false;
    }

    public static function tokenField() {
        $token = self::generateToken();
        echo '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }
}

