<?php


namespace models;


use system\DbModel;

/**
 * Класс пользователей
 */
class User extends DbModel
{
    /**
     * Возвращает название таблицы
     * @return string
     */
    public function getTable()
    {
        return 'users';
    }
}
