<?php

namespace App\Core;

use App\Middleware\Auth;

class Route
{
    private static $get = [];
    private static $post = [];
    private static $middleware = [];

    public static function make()
    {
        $router = new self;
        return $router;
    }

    public function get($path, $action, $middleware = null)
    {
        self::$get[$path] = $action;
        self::$middleware["get"][$path] = $middleware;
        return $this;
    }
    public function post($path, $action, $middleware = null)
    {
        self::$post[$path] = $action;
        self::$middleware["post"][$path] = $middleware;
        return $this;
    }

    public function resolve($uri, $method)
    {

        if (isset(self::$middleware[$method][$uri])) {
            $middleware = self::$middleware[$method][$uri];
            Auth::$middleware();
        }
        if (array_key_exists($uri, self::$$method)) {
            $method = self::$$method[$uri];
            if (is_array($method)) {
                $this->callAction(...$method);
            } else {
                require "views/$method.view.php";
            }
        } else {
            require "404.php";
        }
    }

    private function callAction($controller, $method)
    {
        $controller = new $controller;
        $controller->$method();
    }
}
