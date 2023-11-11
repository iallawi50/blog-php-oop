# Blog

## Using PHP OOP

## By : <a target="_blank" href="https://ali-alabdullah.netlify.app">Ali Al-Abdullah</a>

---

## What did i do ?

- **MVC** ( Model View Controller )
- **OOP** ( Object Orinted Programming )
- **Middleware** ( auth | guest )
- **QueryBuilder**
- **Smaller class model like Laravel**
- **Relationships like laravel** ( belongsto() - hasMany() )
- **Use Packages** (dotenv, Carbon)

---

## Setup

- **Install the packages**

write this command in terminal

```
composer install
```

<br/>

- **Setup Environment (.env)**

```php

APP_URL=folderame

DB_HOST=localhost
DB_NAME=blog
DB_USERNAME=root
DB_PASSWORD=
```

<br/>

- **Create tables or import it from (blog.sql) file**

```sql

CREATE TABLE `users` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(100) NOT NULL UNIQUE,
  `name` text NOT NULL,
  `password` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `posts` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `comments` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `body` text NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

```

---

## Routes

| Method                                             | Path | Action               | Middleware |
| -------------------------------------------------- | ---- | -------------------- | ---------- |
GET | /    | PostController@index |
GET | register | AuthController@register | guest
post | register | AuthController@store | guest
GET | login | AuthController@login | guest
post | login | AuthController@authentication | guest
post | logout | AuthController@logout | auth
GET| posts/show | PostController@show |
GET | posts/create | PostController@create | auth
post | posts/create | PostController@edit | auth
GET | posts/edit | PostController@update | auth
post | posts/edit | PostController@store | auth
post | posts/delete | PostController@delete | auth
post | comments/create | CommentController@store | auth
post | comments/delete | CommentController@delete | auth

---

## Class Model Methods

```php

/*
# For Example i will use User class
# (You Can make like this with any class if you inherit from Model)
/class Child extends Model{}
*/

User::create([  // insert data
    "name" => "Ali",
]);

User::update($id, [ // update data
    "name" => "Ali Hussain",
]);

User::all() // get all Data


User::find($id) // get one column by id
User::find($value, $column, $operator) // get one column by another column

// For Example
User::find("ali", "username", "=") // Where username = ali


User::delete($id) // delete column by id
```

<br/>
<br/>

## Relationships like Laravel

```php

<?php

namespace App\Models;

use Model;

class Post extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
```

**Note:** The table and foreign key name are automatically obtained from the class name. If the table is different, you can specify the table name and you can set the foreign keythrough this code

```php
public static $table = "table_name"; //
```

#### For Example

```php
<?php

namespace App\Models;

use Model;

class Person extends Model
{

    public static $table = "people";


    public function posts()
    {
        return $this->hasMany(Post::class, "person_id");
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, "person_id")
    }

}

```

---

<div align=center>

**Thank You For Reading**

<a  target="_blank" href="https://ali-alabdullah.netlify.app">Ali Al-Abdullah</a>

</div>
