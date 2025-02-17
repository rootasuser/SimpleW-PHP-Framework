<?php

namespace SimpleW;

class Router
{
    protected $routes = [];

    public function addRoute($uri, $controllerAction)
    {
        $this->routes[$uri] = $controllerAction;
    }

    public function dispatch($uri)
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = trim($uri, '/');

        if (array_key_exists($uri, $this->routes)) {
            [$controllerName, $action] = explode('@', $this->routes[$uri]);
            $controller = new $controllerName();
            $controller->$action();
        } else {
            http_response_code(404);
            echo "Page not found!";
        }
    }
}