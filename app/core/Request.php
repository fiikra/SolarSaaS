<?php

namespace App\Core;

class Request {
    public function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public function getBody() {
        $body = [];
        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }
}

