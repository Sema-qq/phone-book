<?php


namespace models;


use models\traits\validators\CaptchaValidate;
use models\traits\validators\LoginValidate;
use system\core\Model;

class LoginForm extends Model
{
    use LoginValidate;
    use CaptchaValidate;

    /** @var string Логин пользователя */
    public $login;
    /** @var string Пароль пользователя */
    public $password;
    /** @var  string Капча */
    public $captcha;

    /** @var bool|User Пользователь */
    private $_user = false;

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
            'captcha' => 'Введите код с картинки'
        ];
    }

    /** @inheritdoc */
    public function validateRules()
    {
        return [
            [['login', 'password', 'captcha'], 'validateRequired'],
            [['login'], 'validateLogin'],
            [['password'], 'validatePassword'],
            [['captcha'], 'validateCaptcha']
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
