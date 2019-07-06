<?php


namespace models;


use system\instruments\FormModel;

class LoginForm extends FormModel
{
    /** @var string Логин пользователя */
    public $login;
    /** @var string Пароль пользователя*/
    public $password;
    /** @var string Повтор пароля пользователя*/
    public $rePassword;
    
    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
            'rePassword' => 'Повтор пароля'
        ];
    }

    /** @inheritdoc */
    public function validateRules()
    {
        return [
            [['login'], 'validateLogin'],
            [['password'], 'validatePassword'],
            [['rePassword'], 'validateRePassword']
        ];
    }

    public function validateLogin($attribute)
    {

    }

    public function validatePassword($attribute)
    {

    }

    public function validateRePassword($attribute)
    {

    }
}
