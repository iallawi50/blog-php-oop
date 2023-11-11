<?php

namespace App\Controllers;

use App\Core\Request;
use App\Middleware\Auth;
use App\Models\Comment;
use App\Models\Post;
use Carbon\Carbon;

class CommentController
{

    public function store()
    {

        $post_id = Request::get("id");
        $body = Request::get("body");

        if ($post_id) {


            // check auth
            if (Auth::check()) {

                $body = str_replace(array("\r", "\n"), '', $body);

                if (trim($body, " ")) {
                    Comment::create([
                        "body" => $body,
                        "user_id" => Auth::user()->id,
                        "post_id" => $post_id,
                        "created_at" => Carbon::now(),
                    ]);
                } else {
                    $_SESSION["errors"] = "لديك حقول فارغ";
                }


                return back();
            } else {
                $_SESSION["not-authorized"] = "غير مصرح";
                return redirect_home();
            }
        } else {
            return notfound();
        }

        // Comment::create();
    }


    public function delete()
    {
        $id = Request::get("id");
        $comment = Comment::find($id);


        if ($comment) {
            $post_owner = Post::find($comment->post_id)->user_id;

            if ($post_owner == Auth::user()->id || $comment->user_id == Auth::user()->id) {
                Comment::delete($id);
            } else {
                return notauthorized();
            }
        } else {
            return notfound();
        }

        return back();
    }
}
