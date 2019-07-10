<?php

namespace models\traits\validators;

use models\User;

trait SignupValidate
{
    public function validateLogin($attribute)
    {
        if (strlen($this->$attribute) < 4) {
            $this->addError($attribute, "Длина поля \"{$this->getAttributeLabel($attribute)}\" не меньше 4 символов.");
        } elseif (strlen($this->$attribute) > 20) {
            $this->addError($attribute, "Длина поля \"{$this->getAttributeLabel($attribute)}\" не больше 20 символов.");
        } elseif (!preg_match('/^[A-Za-z0-9]+$/iu', $this->$attribute)) {
            $this->addError($attribute, "В поле \"{$this->getAttributeLabel($attribute)}\" только латинские буквы и цифры.");
        } elseif (User::findByLogin($this->$attribute)) {
            $this->addError($attribute, "Логин \"{$this->$attribute}\" уже занят.");
        }
    }

    public function validateName($attribute)
    {
        if (strlen($this->$attribute) < 2) {
            $this->addError($attribute, "Длина поля \"{$this->getAttributeLabel($attribute)}\" не меньше 4 символов.");
        } elseif (strlen($this->$attribute) > 20) {
            $this->addError($attribute, "Длина поля \"{$this->getAttributeLabel($attribute)}\" не больше 20 символов.");
        } elseif (!preg_match('/^[а-яёА-ЯЁ]+$/iu', $this->$attribute)) {
            $this->addError($attribute, "В поле \"{$this->getAttributeLabel($attribute)}\" можно использовать только русские буквы.");
        }
    }

    public function validatePassword($attribute)
    {
        if (strlen($this->$attribute) < 8) {
            $this->addError($attribute, "Длина поля \"{$this->getAttributeLabel($attribute)}\" не меньше 8 символов.");
        } elseif (strlen($this->$attribute) > 20) {
            $this->addError($attribute, "Длина поля \"{$this->getAttributeLabel($attribute)}\" не больше 20 символов.");
        } elseif (!preg_match('/^[A-Za-z0-9]+$/iu', $this->$attribute)) {
            $this->addError($attribute, "В поле \"{$this->getAttributeLabel($attribute)}\" можно использовать только латинские буквы и цифры.");
        } elseif (!preg_match('/[A-Za-z]/iu', $this->$attribute)) {
            $this->addError($attribute, "Поле \"{$this->getAttributeLabel($attribute)}\" должно содержать буквы.");
        } elseif (!preg_match('/[0-9]/iu', $this->$attribute)) {
            $this->addError($attribute, "Поле \"{$this->getAttributeLabel($attribute)}\" должно содержать цифры.");
        }
    }

    public function validateRePassword($attribute)
    {
        if ($this->$attribute !== $this->password) {
            $this->addError($attribute, "Пароли не совпадают.");
        }
    }
}
