<?php


namespace models;


use system\instruments\DbModel;

/**
 * Класс пользователей
 */
class User extends DbModel
{
    /**
     * @inheritdoc
     */
    public function getTable()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    function primaryKey()
    {
        return 'ID';
    }
}
