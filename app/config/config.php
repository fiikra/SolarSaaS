<?php

// Fichier de configuration principal de l'application

// Configuration de la base de données
define('DB_HOST', 'localhost'); // ou l'IP de votre serveur de base de données
define('DB_USER', 'root');      // Votre nom d'utilisateur
define('DB_PASS', '');          // Votre mot de passe
define('DB_NAME', 'solarsaas_db'); // Le nom de votre base de données

// Configuration de l'application
define('APP_NAME', 'SolarSaaS');
// IMPORTANT: Définir l'URL de base de votre application. Ex: http://localhost/solarsaas/public/
define('APP_URL', 'http://localhost'); 

// App Root
define('APPROOT', dirname(dirname(__FILE__)));

// URL Root
define('URLROOT', 'http://localhost');

// Site Name
define('SITENAME', 'SolarSaaS');

// Activer/Désactiver l'affichage des erreurs pour le développement
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

