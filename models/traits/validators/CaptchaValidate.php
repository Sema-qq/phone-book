<?php

namespace models\traits\validators;


use system\core\App;

trait CaptchaValidate
{
    public function validateCaptcha($attribute)
    {
        if ($this->$attribute !== App::$components->session->get('captcha')) {
            $this->addError($attribute, "Введенный код не совпадает с картинкой.");
        }
    }
}