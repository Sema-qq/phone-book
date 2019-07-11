<?php
/**
 * @var \controllers\ContactController $this
 * @var \models\Contact $model
 */

use extensions\HtmlHelper;
?>
<div class="container">
    <?= HtmlHelper::errors($model, 'ALL') ?>
    <form action="/contact/<?= $model->ID ? 'update/' . $model->ID : 'create' ?>" method="post">
        <div class="form-group">
            <?= HtmlHelper::textInput($model, 'FIRST_NAME', ['class' => 'form-control']) ?>
        </div>
        <div class="form-group">
            <?= HtmlHelper::textInput($model, 'LAST_NAME', ['class' => 'form-control']) ?>
        </div>
        <div class="form-group">
            <?= HtmlHelper::textInput($model, 'PHONE', [
                'class' => 'form-control',
                'required' => true
            ]) ?>
        </div>
        <div class="form-group">
            <?= HtmlHelper::textInput($model, 'EMAIL', ['class' => 'form-control']) ?>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>
