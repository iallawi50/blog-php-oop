<?php

namespace App;

use PDO;

class DBConnection
{
        // $host = App::$entries['config']['database']['DB_HOST'];

    public static function make()
    {
        $host = App::$entries['config']['database']['DB_HOST'] ?? "localhost";
        $dbname = App::$entries['config']['database']['DB_NAME'] ?? "";
        $username = App::$entries['config']['database']['DB_USERNAME'] ?? "root";
        $password = App::$entries['config']['database']['DB_PASSWORD'] ?? "";
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", $password);
            return $pdo;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}