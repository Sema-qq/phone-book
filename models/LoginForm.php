<?php


namespace models;


use system\instruments\FormModel;

class LoginForm extends FormModel
{
    /** @var string Логин пользователя */
    public $login;
    /** @var string Пароль пользователя */
    public $password;

    /** @var bool|User Пользователь */
    private $_user = false;

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'password' => 'Пароль'
        ];
    }

    /** @inheritdoc */
    public function validateRules()
    {
        return [
            [['login'], 'validateLogin'],
            [['password'], 'validatePassword']
        ];
    }

    public function validateLogin($attribute)
    {
        if (!$this->$attribute) {
            $this->addError($attribute, "Поле \"{$this->getAttributeLabel($attribute)}\" не заполнено.");
        } elseif (!$this->getUser()) {
            $this->addError($attribute, "Пользователь с логином \"{$this->$attribute}\" не найден.");
        }
    }

    public function validatePassword($attribute)
    {
        if (!$this->$attribute) {
            $this->addError($attribute, "Поле \"{$this->getAttributeLabel($attribute)}\" не заполнено.");
        } elseif (!$this->_user->validatePassword($this->$attribute)) {
            $this->addError($attribute, "Поле \"{$this->getAttributeLabel($attribute)}\" заполнено не верно.");
        }
    }

    /**
     * @return User
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByLogin($this->login);
        }

        return $this->_user;
    }
}
