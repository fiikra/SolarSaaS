<?php
// app/core/Language.php

namespace App\Core;

class Language {
    private static $translations = [];

    public static function load($lang = 'en') {
        $langFile = APPROOT . '/languages/' . $lang . '.php';
        if (file_exists($langFile)) {
            self::$translations = require $langFile;
        } else {
            // Fallback to English if language file not found
            self::$translations = require APPROOT . '/languages/en.php';
        }
    }

    public static function get($key, $default = '') {
        return self::$translations[$key] ?? $default;
    }
}

function trans($key, $default = '') {
    return \App\Core\Language::get($key, $default);
}
