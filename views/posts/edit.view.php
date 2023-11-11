<?php

use App\Core\Request;

if (isset($_SESSION["errors"])) {
    $errors = $_SESSION["errors"];
    unset($_SESSION["errors"]);
}

?>
<div class="container mt-5">

    <form method=post class="shadow col-md-8  mx-auto" action="<?= home() ?>/posts/edit">
        <input type="text" name="id" hidden value="<?= Request::get("id") ?>">
        <div class="p-3">
            <h1 class="text-center">تعديل المقالة</h1>
            <?php component("post-form", [
                "title" => $title ?? "",
                "body" => $body ?? "",
                "errors" => $errors ?? []
            ]); ?>
            <button type="submit" class="btn btn-success rounded-0 col-12">تعديل</button>
    </form>
</div>