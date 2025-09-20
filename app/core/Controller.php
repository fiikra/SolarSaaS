<?php

namespace App\Core;

/*
 * Base Controller
 * Loads the models and views
 */
class Controller {
    // Load model
    public function model($model) {
        // Require model file
        require_once '../app/Models/' . $model . '.php';
        $modelClass = 'App\\Models\\' . $model;
        // Instantiate model
        return new $modelClass();
    }

    // Load view
    public function view($view, $data = [], $layout = 'default') {
        // Check for view file
        if (file_exists('../app/Views/' . $view . '.php')) {
            // If a layout is specified, load it. Otherwise, just load the view.
            if ($layout) {
                if (file_exists('../app/Views/layouts/' . $layout . '.php')) {
                    require_once '../app/Views/layouts/' . $layout . '.php';
                } else {
                    die('Layout does not exist');
                }
            } else {
                 require_once '../app/Views/' . $view . '.php';
            }
        } else {
            // View does not exist
            die('View does not exist: ' . $view);
        }
    }

    protected function redirect($url) {
        header('Location: ' . URLROOT . '/' . $url);
        exit();
    }

    protected function protect() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('login');
        }
    }

    // Set flash message
    protected function setFlash($name, $message, $class = 'success') {
        if (!empty($name)) {
            if (!empty($message) && empty($_SESSION[$name])) {
                if (!empty($_SESSION[$name])) {
                    unset($_SESSION[$name]);
                }
                if (!empty($_SESSION[$name . '_class'])) {
                    unset($_SESSION[$name . '_class']);
                }
                $_SESSION[$name] = $message;
                $_SESSION[$name . '_class'] = $class;
            }
        }
    }
}

