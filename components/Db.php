<?php


namespace components;

use PDO;

/**
 * Класс для подключения к базе данных
 */
class Db
{
    /** @var PDO объект базы данных */
    private static $db = null;

    /**
     * Возвращает объект подключения к базе данных
     * @return PDO
     */
    public static function getConnection()
    {
        if (!self::$db) {

            $params = require ROOT . 'config/db.php';

            self::$db = new PDO(
                $params['dsn'],
                $params['user'],
                $params['password']
            );
        }

        return self::$db;
    }

    private function __clone () {}
}
