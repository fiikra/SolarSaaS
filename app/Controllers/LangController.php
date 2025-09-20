<?php

namespace App\Controllers;

use App\Core\Controller;

class LangController extends Controller
{
    public function switch($lang)
    {
        if (in_array($lang, ['en', 'fr', 'ar'])) {
            $_SESSION['lang'] = $lang;
        }

        // Redirect back to the previous page
        if (isset($_SERVER['HTTP_REFERER'])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        // Fallback if referer is not set
        header('Location: ' . URLROOT);
        exit();
    }
}
