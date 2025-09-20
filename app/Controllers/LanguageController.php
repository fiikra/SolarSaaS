<?php

namespace App\Controllers;

use App\Core\Controller;

class LanguageController extends Controller
{
    public function switch($lang)
    {
        if (in_array($lang, ['en', 'fr', 'ar'])) {
            $_SESSION['lang'] = $lang;
        }

        // Redirect back to the previous page
        $referer = $_SERVER['HTTP_REFERER'] ?? URLROOT;
        header("Location: " . $referer);
        exit();
    }
}
