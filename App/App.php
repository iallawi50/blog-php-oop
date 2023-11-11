<?php

namespace App;
class App
{

    
    public static $entries = [];

    public static function set($key, $value)

    {
        self::$entries[$key] = $value;
    }

}