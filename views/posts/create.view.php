<?
?>
<div class="container mt-5">

    <form method=post class="shadow col-md-8  mx-auto" action="<?= home() ?>/posts/create">
    
        <div class="p-3">
            <h1 class="text-center">اضافة مقالة جديدة</h1>
            <?php component("post-form", [
                "title" => $title ?? "",
                 "body" => $body ?? "",
                 "errors" => $errors ?? []
            ]); ?>

            <button type="submit" class="btn btn-success rounded-0 col-12">نشر</button>
    </form>
</div>