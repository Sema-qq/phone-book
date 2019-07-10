<?php


namespace models;


use system\core\DbModel;

/**
 * Класс пользователей
 */
class User extends DbModel
{
    /** @var int primaryKey */
    public $ID;
    /** @var string Имя пользователя */
    public $NAME;
    /** @var string Логин пользователя */
    public $LOGIN;
    /** @var string Пароль пользователя */
    public $PASSWORD;

    /** @inheritdoc */
    public function getTable()
    {
        return 'users';
    }

    /** @inheritdoc */
    function primaryKey()
    {
        return 'ID';
    }

    /** @inheritdoc */
    public function fields()
    {
        return [
            'ID',
            'NAME',
            'LOGIN',
            'PASSWORD'
        ];
    }

    public static function findByLogin($login)
    {
        return User::find()->where(['LOGIN' => $login])->one();
    }

    public function create()
    {
        $this->PASSWORD = sha1($this->PASSWORD);
        return $this->save(false);
    }

    public function validatePassword($password)
    {
        return $this->PASSWORD == sha1($password);
    }
}
