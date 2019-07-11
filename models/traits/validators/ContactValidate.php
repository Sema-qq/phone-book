<?php

namespace models\traits\validators;


trait ContactValidate
{
    public function validateName($attribute)
    {
        if (strlen($attribute) > 20) {
            $this->addError($attribute, "В поле \"{$this->getAttributeLabel($attribute)}\" длина не больше 20 символов.");
        }
    }
    
    public function validatePhone($attribute)
    {
        if (!preg_match('/((8|\+7)-?)?\(?\d{3,5}\)?-?\d{1}-?\d{1}-?\d{1}-?\d{1}-?\d{1}((-?\d{1})?-?\d{1})?/', $this->$attribute)) {
            $this->addError($attribute, "Поле \"{$this->getAttributeLabel($attribute)}\" заполнено не верно");
        }
    }
    
    public function validateEmail($attribute)
    {
        if ($this->$attribute && !filter_var($this->$attribute, FILTER_VALIDATE_EMAIL)) {
            $this->addError($attribute, "Поле \"{$this->getAttributeLabel($attribute)}\" должно быть типа \"mail@mail.ru\"");
        }
    }
}
