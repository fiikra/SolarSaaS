<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * Contrôleur pour la page d'accueil et les pages statiques.
 */
class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil.
     * Si l'utilisateur est connecté, redirige vers le tableau de bord.
     */
    public function index()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . APP_URL . '/projects'); // Redirige vers la liste des projets
            exit();
        }
        
        $this->view('home/index', ['title' => trans('home')], 'home');
    }
    
    /**
     * Affiche la page 404.
     */
    public function notFound()
    {
        http_response_code(404);
        $this->view('errors/404', ['title' => 'Page Not Found']);
    }
}

