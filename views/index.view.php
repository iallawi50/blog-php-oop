<?php

use App\Middleware\Auth;
use App\Models\User;



?>

<div class="container mt-5">
    
    <div class="row">
        <?php
        if (isset($_SESSION["not-authorized"])) : ?>

            <div class="alert alert-danger text-center"><?= $_SESSION["not-authorized"] ?></div>

            <?php unset($_SESSION["not-authorized"]); ?>

        <?php elseif (isset($_SESSION["post-deleted"])) : ?>

            <div class="alert alert-success text-center"><?= $_SESSION["authorized"] ?></div>

            <?php unset($_SESSION["authorized"]); ?>

        <?php endif ?>


        <?php if (!count($posts)) : ?>

            <div class="text-center alert alert-info">لاتوجد مقالات</div>
            <?php if (Auth::check()) : ?>
                <div class="text-center"><a href="<?= home() ?>/posts/create" class="btn btn-primary rounded-0">اضف مقالة</a></div>
            <?php endif ?>
        <?php endif ?>
        <?php foreach ($posts as $post) : ?>
            <div class="col-md-12 bg-dark my-3 text-white py-3 d-flex justify-content-between align-items-center rounded-3">
                <div>
                    <h4><?= $post->title ?></h4>
                    <p>للكاتب <?= $post->user()->name ?></p>
                    <?php

                    ?>
                </div>
                <div>
                    <a href="<?= home() ?>/posts/show?id=<?= $post->id ?>" class="btn btn-primary" role="button">اقرأ</a>
                    <?php
                    if (Auth::check() && $post->user_id == Auth::user()->id) :
                    ?>
                        <a href="<?= home() ?>/posts/edit?id=<?= $post->id ?>" class="btn btn-warning" role="button">تعديل</a>
                        <form class="d-inline" method="post" action="<?= home() ?>/posts/delete?id=<?= $post->id ?>">
                            <button onclick="return confirm('هل انت متأكد من حذف المقالة')" class="btn btn-danger">حذف</button>
                        </form>
                    <?php endif ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>