<?php

namespace App\Core;

use App\App;

class Request
{

    public static function uri()
    {

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = trim($uri, "/");
        $uri = str_replace(App::$entries["config"]["app"]["url"], "", $uri);
        $uri = trim($uri, "/");
        // $uri = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] . "/" . $uri;

        return $uri;
    }

    public static function get($key, $default = null)
    {
        $key = $_GET[$key] ?? $_POST[$key] ?? $default;
        return htmlspecialchars($key);
    }


    public static function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}
