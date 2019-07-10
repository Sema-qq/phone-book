<?php
/**
 * @var \system\core\Controller $this
 * @var \models\SignupForm $model
 */
use extensions\HtmlHelper;

?>
<h1>Регистрация</h1>
<div class="container">
    <form method="post" id="auth-form">
        <div class="form-group">
            <?= HtmlHelper::textInput($model, 'name', [
                'class' => 'form-control',
                'required' => true
            ])?>
        </div>
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
            <?= HtmlHelper::passwordInput($model, 'rePassword', [
                'class' => 'form-control',
                'required' => true
            ])?>
        </div>
        <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
    </form>
</div>
