<?php
/**
 * @var \controllers\ContactController $this
 * @var \models\Contact $model
 */
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/contact/index">Контакты</a></li>
        <li class="breadcrumb-item active">Изменение контакта</li>
        <li class="breadcrumb-item active"><?= $model->FIRST_NAME ?></li>
    </ol>
</nav>
<h2>Изменение контакта "<?= $model->FIRST_NAME ?>"</h2>