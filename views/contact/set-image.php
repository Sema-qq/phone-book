<?php
/**
 * @var \controllers\ContactController $this
 * @var \models\Contact $model
 * @var \models\ImageUpload $image
 */

use extensions\HtmlHelper;
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/contact/index">Контакты</a></li>
        <li class="breadcrumb-item"><a href="/contact/view/<?= $model->ID ?>"><?= $model->FIRST_NAME ?></a></li>
        <li class="breadcrumb-item active">Добавление фото</li>
    </ol>
</nav>
<h2>Добавление фото для контакта <?= $model->FIRST_NAME ?></h2>
<div class="container">
    <?= HtmlHelper::errors($image, 'ALL') ?>
    <?= HtmlHelper::errors($model, 'ALL') ?>
    <form action="/contact/set-image/<?= $model->ID ?>" method="post" enctype=multipart/form-data>
        <div class="form-group">
            <?= HtmlHelper::fileInput($image, 'image', [
                'class' => 'form-control-file',
                'required' => true
            ]) ?>
        </div>
        <button type="submit" class="btn btn-primary">Загрузить</button>
    </form>
</div>
