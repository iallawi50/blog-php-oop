<?php

namespace App;


class QueryBuilder


{
    public static $pdo;
    public static $log;

    public static function make(\PDO $pdo, $log)
    {
        self::$pdo = $pdo;
        self::$log = $log;
    }
    public static function select($table, $where = null, $oneColumn = false, $class = null)
    {


        $query = "SELECT * FROM $table";
        is_array($where)
            ?    $query .= " WHERE $where[0] $where[1] '$where[2]'"
            : null;

        if ($oneColumn) {
            return self::execute($query)->fetch(\PDO::FETCH_OBJ);
        } else {
            if($class)
            {
                return self::execute($query)->fetchAll(\PDO::FETCH_CLASS, $class);
            }else 
            {
                return self::execute($query)->fetchAll(\PDO::FETCH_OBJ);
            }
        }
    }

    public static function insert($table, $data)
    {
        $columns = implode(",", array_keys($data));
        $values = str_repeat("?,", count(array_keys($data)) - 1) . "?";


        $query = "INSERT INTO $table ($columns) values ($values)";
        self::execute($query, array_values($data));
    }

    public static function delete($table, $id, $col = "id", $operator = "=")
    {
        $query = "DELETE FROM $table where $col $operator '$id'";

        self::execute($query);
    }


    public static function update($table, $id, $where)
    {
        $sets = implode("=?, ", array_keys($where)) . "=?" ;
        $query = "UPDATE $table set $sets where id = $id";
         self::execute($query, array_values($where));    
    }

    private static function execute($query, $values = [])
    {
        self::$log->debug($query);
        $statement = self::$pdo->prepare($query);
        $statement->execute($values);
        return $statement;
    }
}
