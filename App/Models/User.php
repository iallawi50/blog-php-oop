<?php

namespace App\Models;

use Model;

class User extends Model
{ 

    // public static $table = "users";

   

    public function posts()
    {
        return $this->hasMany(Post::class);
    }


}
