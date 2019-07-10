<?php


namespace models;


use models\traits\validators\SignupValidate;
use system\core\Model;

class SignupForm extends Model
{
    use SignupValidate;

    public $login;
    public $name;
    public $password;
    public $rePassword;

    public $_user;

    public function validateRules()
    {
        return [
            [['login', 'password', 'name', 'rePassword'], 'validateRequired'],
            [['login'], 'validateLogin'],
            [['name'], 'validateName'],
            [['password'], 'validatePassword'],
            [['rePassword'], 'validateRePassword']
        ];
    }

    /** @inheritDoc */
    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'name' => 'Имя пользователя',
            'password' => 'Пароль',
            'rePassword' => 'Повтор пароля'
        ];
    }

    public function getUser()
    {
        return $this->_user;
    }
    
    public function save()
    {
        if ($this->validate()) {
            $user = new User([
                'LOGIN' => $this->login,
                'NAME' => $this->name,
                'PASSWORD' => $this->password
            ]);

            if ($user->create()) {
                $this->_user = $user;
                return true;
            }
        }

        return false;
    }
}
