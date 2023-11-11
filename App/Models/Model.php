<?php

use App\Models\User;
use App\QueryBuilder;




abstract class Model
{



    public static $table;

    public static function all($latest = true)
    {
        $table = self::getTable();
        $class = static::class;

        if ($latest) {
            return array_reverse(QueryBuilder::select($table, class: $class));
        }
        return QueryBuilder::select($table, class: $class);
    }

    public static function find($id, $col = 'id', $operator = "=")
    {

        $table = self::getTable();
        $data = QueryBuilder::select($table, [$col, $operator, $id], true);

        if ($data) {
            $class = new static;

            foreach ($data as $key => $value) {

                $class->$key = $value;
            }

            return $class;
        } else {
            return $data;
        }
    }


    public static function delete($id)
    {
        $table = self::getTable();
        QueryBuilder::delete($table, $id);
    }
    public static function update($id, $data)
    {
        $table = self::getTable();
        QueryBuilder::update($table, $id, $data);
    }

    public static function create($data)
    {
        $table = self::getTable();

        QueryBuilder::insert($table, $data);
    }

    public function hasMany($related, $related_id = null)
    {

        /*
        For Example
        User hasMany(Post::class)
        */

        // First get User::class;
        $table = self::getTable();





        // Then Get RelatedTable // posts
        $relatedTable = $related::getTable();


        // then check related_id if it has value or not

        // if not has we will generate value from related table name /
        if ($related_id == null) {
            $related_id = $table; // get table name // users
            $related_id[-1] = "_";  // change last char from "s" to "_" to be "user_"
            $related_id .= "id"; // add "id" to be "user_id"
        }


        //   -->                         posts           user_id        $post->id,  class: Post
        return QueryBuilder::select($relatedTable, ["$related_id", "=", $this->id], class: $related);
    }


    public function belongsTo($related, $related_id = null)
    {
        /*
        For Example
        Post belongsTo(User::class)
        */

        if (!$related_id) {
            $related_id = $related::getTable(); // get related table // users
            $related_id[-1] = "_"; // change last char from "s" to "_" to be "user_
            $related_id .= "id"; // add "id" to be "user_id"
        }

        return $related::find($this->$related_id);


    }

    private static function getTable()
    {

        if (static::$table) {
            $table = static::$table;
        } else {
            $explode = explode("\\", strtolower(static::class));
            $table = ($explode[count($explode) - 1]) . "s";
        }

        return $table;
    }


}
