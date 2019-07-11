<?php
/**
 * @var \controllers\ContactController $this
 * @var \models\Contact[] $contacts
 */

use extensions\HtmlHelper;
use models\Contact;
use system\core\Controller;

//$this->registerJsFile(Controller::TEMPLATE_FOLDER . 'js/contact.js');
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
        'EMAIL'
    ], [
        'ID',
        'FIRST_NAME',
        'LAST_NAME',
        'PHONE',
        'EMAIL'
    ], 'contact') ?>
</div>


