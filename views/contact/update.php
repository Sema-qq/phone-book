<?php
/**
 * @var \controllers\ContactController $this
 * @var \models\Contact $model
 */
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/contact/index">Контакты</a></li>
        <li class="breadcrumb-item"><a href="/contact/view/<?= $model->ID ?>"><?= $model->FIRST_NAME ?></a></li>
        <li class="breadcrumb-item active">Редактирование контакта</li>
    </ol>
</nav>
<h2>Редактирование контакта "<?= $model->FIRST_NAME ?>"</h2>
<?= $this->renderPartial('_form', compact('model')) ?>
