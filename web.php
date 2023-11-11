<?php

require "./__init.php";

use App\Controllers\AuthController;
use App\Controllers\CommentController;
use App\Controllers\PostController;
use App\Core\Request;
use App\Core\Route;

Route::make()
    // Posts
    ->get("", [PostController::class, "index"])
    ->get("posts/show", [PostController::class, "show"])
    ->get("posts/create", [PostController::class, "create"], "auth")
    ->post("posts/create", [PostController::class, "store"], "auth")
    ->get("posts/edit", [PostController::class, "edit"], "auth")
    ->post("posts/edit", [PostController::class, "update"], "auth")
    ->post("posts/delete", [PostController::class, "delete"], "auth")

    // Comments
    ->post("comments/create", [CommentController::class, "store"], "auth")
    ->post("comments/delete", [CommentController::class, "delete"], "auth")


    // Authentication
    ->get("register", [AuthController::class, "register"], "guest")
    ->post("register", [AuthController::class, "store"], "guest")
    ->get("login", [AuthController::class, "login"], "guest")
    ->post("login", [AuthController::class, "authentication"], "guest")
    ->post("logout", [AuthController::class, "logout"], "auth")



    ->resolve(Request::uri(), Request::method());
