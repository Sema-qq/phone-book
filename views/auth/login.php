<?php
/**
 * @var \system\core\Controller $this
 * @var \models\LoginForm $model
 */
use extensions\HtmlHelper;

$this->registerJsFile('/templates/js/captcha.js');
?>
<h1>Авторизация</h1>
<div class="container">
    <?= HtmlHelper::errors($model, 'ALL') ?>
    <form method="post" id="auth-form">
        <div class="form-group">
            <?= HtmlHelper::textInput($model, 'login', [
                'class' => 'form-control',
                'required' => true
            ])?>
        </div>
        <div class="form-group">
            <?= HtmlHelper::passwordInput($model, 'password', [
                'class' => 'form-control',
                'required' => true
            ])?>
        </div>
        <div class="form-group">
            <?= HtmlHelper::captcha($model, 'captcha', [
                'class' => 'form-control',
                'required' => true
            ], [
                'src' => '/auth/captcha',
                'class' => 'js-captcha-img'
            ]) ?>
        </div>
        <button type="submit" class="btn btn-primary">Войти</button>
    </form>
</div>
