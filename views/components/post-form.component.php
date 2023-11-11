    
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">العنوان</label>
            <input type="text" name="title" value="<?= $title ?? "" ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <p class="text-danger"><?= $errors["title"] ?? '' ?></p>
        </div>

        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">نص المقالة</label>
            <textarea name="body" class="form-control" style="height: 200px;" id="exampleInputPassword1"><?=$body??""?></textarea>
            <p class="text-danger"><?= $errors["body"] ?? '' ?></p>

        </div>
    </div>