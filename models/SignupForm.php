<?php


namespace models;


use models\traits\validators\CaptchaValidate;
use models\traits\validators\SignupValidate;
use system\core\Model;

class SignupForm extends Model
{
    use SignupValidate;
    use CaptchaValidate;

    /** @var  string Логин */
    public $login;
    /** @var  string Имя */
    public $name;
    /** @var  string Пароль */
    public $password;
    /** @var  string Повтор пароля */
    public $rePassword;
    /** @var  string Капча */
    public $captcha;

    /** @var  User */
    public $_user;

    /** @inheritdoc */
    public function validateRules()
    {
        return [
            [['login', 'password', 'name', 'rePassword', 'captcha'], 'validateRequired'],
            [['login'], 'validateLogin'],
            [['name'], 'validateName'],
            [['password'], 'validatePassword'],
            [['rePassword'], 'validateRePassword'],
            [['captcha'], 'validateCaptcha']
        ];
    }

    /** @inheritDoc */
    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'name' => 'Имя пользователя',
            'password' => 'Пароль',
            'rePassword' => 'Повтор пароля',
            'captcha' => 'Введите код с картинки'
        ];
    }

    /**
     * Возвращает пользователя
     * @return User
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * Сохраняет пользователя
     * @return bool
     */
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
