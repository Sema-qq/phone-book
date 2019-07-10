<?php


namespace models;


use models\traits\validators\LoginValidate;
use system\instruments\FormModel;

class LoginForm extends FormModel
{
    use LoginValidate;

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
            [['login', 'password'], 'validateRequired'],
            [['login'], 'validateLogin'],
            [['password'], 'validatePassword']
        ];
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
