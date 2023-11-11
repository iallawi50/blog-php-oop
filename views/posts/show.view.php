<?php

use App\Middleware\Auth;
use App\Models\User;
use Carbon\Carbon;

?>

<div class="container mt-3">

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <?= $post->title ?>

                <div>
                    <?= Carbon::parse($post->created_at)->diffForHumans(); ?>
                </div>
            </div>

        </div>
        <p class="card-body" style="white-space: pre;"><?= $post->body ?></p>


        <div class="card-footer d-flex justify-content-between align-items-center">
            <?php


            if (Auth::user()->id == $post->user_id) : ?>

                <a href="<?= home() ?>/posts/edit?id=<?= $post->id ?>" class="btn btn-warning" role="button">تعديل</a>


                <form method="post" action="<?= home() ?>/posts/delete?id=<?= $post->id ?>">
                    <button onclick="return confirm('هل انت متأكد من حذف المقالة')" class="btn btn-danger">حذف</button>
                </form>
            <?php else : ?>


                <p class="mb-0">للكاتب : <?= User::find($post->user_id)->name ?></p>
                <p class="mb-0">عدد التعليقات : <?= count($post->comments()) ?></p>
            <?php endif ?>
        </div>

    </div>




    <div action class="mt-5 p-3 card">
        <h5 class="text-center">التعليقات</h5>


        <?php foreach ($post->comments() as $comment) : ?>
            <div class="mt-1">
                <div class="d-flex justify-content align-items-center justify-content-between">
                    <h6 class="px-2 mt-1 py-1"><?= $comment->user()->name ?>
                
                    <?php if ($post->user_id == $comment->user_id) : ?>
                        <span class="badge text-bg-primary">الكاتب</span>
                    <?php endif ?>
                </h6>


                <?php if($comment->user_id == Auth::user()->id || Auth::user()->id == $post->user_id) : ?>
                    
                    <form method="post" action="<?= home() ?>/comments/delete?id=<?= $comment->id ?>">
                        <button onclick="return confirm('هل انت متأكد من حذف المقالة')" class="btn btn-danger">حذف</button>
                    </form>

                    <?php endif ?>

                </div>

                <p class="px-2"><?= $comment->body ?> </p>
                <span class="text-muted" style="font-size: 13px;"><?= Carbon::parse($comment->created_at)->diffForHumans() ?></span>
                <hr>

            </div>
        <?php endforeach ?>


        <?php if (Auth::check()) : ?>
            <form action="<?= home() ?>/comments/create?id=<?= $post->id ?>" class="mt-5 p-3 card" method="post">
                <label class="p-2">التعليق</label>

                <div class="form-group d-flex justify-content-between">
                    <input type="text" name="body" class="form-control rounded-end-0">
                    <button class="btn btn-primary rounded-start-0">Send</button>
                </div>
                <?php if (isset($_SESSION["errors"])) : ?>
                    <p class="text-danger mt-2 mb-0"><?= $_SESSION["errors"] ?></p>
                <?php endif;
                unset($_SESSION["errors"]);
                ?>
            </form>
    </div>

<?php endif ?>


</div>