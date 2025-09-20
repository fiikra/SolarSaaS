<?php

namespace App\Core;

class Router {
    protected $routes = [
        'GET' => [],
        'POST' => []
    ];

    public function get($uri, $controller) {
        $uri = trim($uri, '/');
        if(empty($uri)) $uri = '/';
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller) {
        $uri = trim($uri, '/');
        if(empty($uri)) $uri = '/';
        $this->routes['POST'][$uri] = $controller;
    }

    public function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        // Remove base directory from URI if the app is in a subdirectory
        $baseDir = str_replace('/public/index.php', '', $_SERVER['SCRIPT_NAME']);
        if (strpos($uri, $baseDir) === 0) {
            $uri = substr($uri, strlen($baseDir));
        }
        
        $uri = trim($uri, '/');
        if(empty($uri)) $uri = '/';

        foreach ($this->routes[$method] as $route => $controllerAction) {
            // Convert route to regex: /users/{id} -> /users/(\w+)
            $routeRegex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route);
            $routeRegex = '#^' . $routeRegex . '$#';

            if (preg_match($routeRegex, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                list($controller, $action) = explode('@', $controllerAction);
                $controller = "App\\Controllers\\" . $controller;

                if (class_exists($controller)) {
                    $controllerInstance = new $controller();
                    if (method_exists($controllerInstance, $action)) {
                        call_user_func_array([$controllerInstance, $action], $params);
                        return;
                    }
                }
            }
        }

        // If no route matched
        $this->notFound();
    }

    protected function notFound() {
        http_response_code(404);
        require_once APPROOT . '/Views/errors/404.php';
        exit();
    }
}

