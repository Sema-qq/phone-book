<?php


namespace models\traits\validators;


use models\User;

trait LoginValidate
{
    public function validateLogin($attribute)
    {
        if (!$this->getUser()) {
            $this->addError($attribute, "Пользователь с логином \"{$this->$attribute}\" не найден.");
        }
    }

    public function validatePassword($attribute)
    {
        if ($this->_user instanceof User && !$this->_user->validatePassword($this->$attribute)) {
            $this->addError($attribute, "Поле \"{$this->getAttributeLabel($attribute)}\" заполнено не верно.");
        }
    }
}
