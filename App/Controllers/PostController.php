<?php

namespace App\Controllers;

use App\Core\Request;
use App\Middleware\Auth;
use App\Models\Post;
use Carbon\Carbon;

class PostController
{
    public function index()
    {



        $posts = Post::all();

        return view("index", [
            "posts" => $posts
        ]);
    }

    public function create()
    {
        return view("posts/create");
    }


    public function store()
    {
        $title = Request::get("title");
        $body = Request::get("body");
        $send = true;
        $data = [
            "title" => $title,
            "body" => $body,
            "errors" => []
        ];

        $extracting = $this->validate($title, $body);
        // print_r($extracting);
        $test = extract($extracting);
        $data["errors"] = $errors;
        if ($send) {
            Post::create([
                "title" => $title,
                "body" => $body,
                "user_id" => Auth::user()->id,
                "created_at" => Carbon::now(),
            ]);

            return redirect_home();
        }
        return view("posts/create", $data);
    }

    public function show()
    {
        $post = $this->getPost();

        return view("posts/show", ["post" => $post]);
    }
    public function delete()
    {

        $post = $this->getPost(true);

        if ($post->user_id == Auth::user()->id) {
            $_SESSION["authorized"] = "تم حذف المقالة بنجاح";
            Post::delete($post->id);
            redirect_home();
        }
    }


    public function edit()
    {

        $post = $this->getPost(true);

        $data = [
            "title" => $post->title,
            "body" => $post->body,
        ];
        return view("posts/edit", $data);
    }

    public function update()
    {
        $post = $this->getPost(true);
        $title = Request::get("title");
        $body = Request::get("body" );
        $send = true;
        $data = [
            "title" => $title,
            "body" => $body,
            "errors" => []
        ];
        $extracting = $this->validate($title, $body);

        $data["errors"]  = $extracting["errors"];
        $send = $extracting["send"];


        if ($send) {
            Post::update(
                $post->id,
                [
                    "title" => $title,
                    "body" => $body,
                    "updated_at" => Carbon::now(),
                ]

            );
            return redirect(home() . "/posts/show?id=$post->id");
        } else {

            $_SESSION["errors"] = $data["errors"];
        }
        return back();
    }


    private function getPost($authorize = false)
    {
        $id = Request::get("id");
        $post = Post::find($id);
        if (!$post) {
            return notfound();
        }



        if ($authorize) {
            if ($post->user_id != Auth::user()->id) {
                $_SESSION["not-authorized"] = "غير مصرح";
                return redirect_home();
            }
        }



        return $post;
    }



    private function validate($title, $body)
    {

        $title = str_replace(array("\r", "\n"), '', $title);
        $checkBody = str_replace(array("\r", "\n"), '', $body);

        $errors = [];
        $send = true;
        if (empty(trim($title))) {
            $errors["title"] = "حقل العنوان فارغ";
            $send = false;
        }



        if (empty(trim($checkBody))) {
            $errors["body"] = "نص المقالة فارغ";
            $send = false;
        }

        return [
            "errors" => $errors,
            "send" => $send,
        ];
    }
}
