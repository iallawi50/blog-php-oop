<?php

namespace App\Models;

use Model;

class User extends Model
{ 

    // public static $table = "users";

    // public static $name = "gg";
    public $id;
    public $name;
    public $username;
    public $created_at;
    public $password;

   

    public function posts()
    {
        return $this->hasMany(Post::class);
    }


}
