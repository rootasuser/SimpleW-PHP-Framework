<?php

namespace SimpleW\Core;

class App {
    protected $controller = "HomeController"; // Default controller
    protected $method = "index";
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();
        
        $controllerClass = "SimpleW\\Controllers\\" . $this->controller; // ✅ Ensure full namespace

        if (class_exists($controllerClass)) {
            $this->controller = new $controllerClass;
        } else {
            die("Controller not found: " . $controllerClass); // Debugging message
        }

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl() {
        return isset($_GET['url']) ? explode("/", filter_var(rtrim($_GET['url'], "/"), FILTER_SANITIZE_URL)) : [];
    }
}
