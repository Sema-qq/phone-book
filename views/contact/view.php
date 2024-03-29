<?php
/**
 * @var \controllers\ContactController $this
 * @var \models\Contact $model
 */

use extensions\HtmlHelper;
use extensions\Converter;
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/contact/index">Контакты</a></li>
        <li class="breadcrumb-item active">Просмотр контакта</li>
        <li class="breadcrumb-item active"><?= $model->FIRST_NAME ?></li>
    </ol>
</nav>
<h2>Просмотр контакта <?= $model->FIRST_NAME ?></h2>
<div class="container">
    <div class="row">
        <a class="btn btn-light" role="button" href="/contact/update/<?= $model->ID ?>">Редактировать</a>
        <a class="btn btn-light" role="button" href="/contact/set-image/<?= $model->ID ?>">
            <?= $model->PHOTO ? 'Изменить фото' : 'Добавить фото' ?>
        </a>
    </div>
    <br>
    <?= HtmlHelper::tableView($model, [
        'ID',
        'FIRST_NAME',
        'LAST_NAME',
        'PHONE',
        'EMAIL'
    ])?>
    <div class="row">
        <b>Телефон строкой:</b>&#8194;<i><?= Converter::convert($model->PHONE)?></i>
    </div>
</div>
