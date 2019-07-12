<?php
/**
 * @var \controllers\ContactController $this
 * @var Contact[] $contacts
 */

use extensions\HtmlHelper;
use models\Contact;

$this->registerJsFile('/templates/js/contact.js');
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Контакты</li>
    </ol>
</nav>
<h2>Контакты</h2>
<div class="container">
    <div class="row">
        <a class="btn btn-light" role="button" href="/contact/create">Добавить контакт</a>
    </div>
    <br>
    <?= HtmlHelper::tableIndex($contacts, new Contact(), [
        'ID',
        'FIRST_NAME',
        'LAST_NAME',
        'PHONE',
        'EMAIL',
        'PHOTO'
    ], [
        'ID',
        'FIRST_NAME',
        'LAST_NAME',
        'PHONE',
        'EMAIL'
    ], 'contact') ?>
</div>
