<?php


namespace system;

use system\core\Db;
use system\core\Model;

/**
 * Базовый клас модели для работы с базой данных
 */
abstract class DbModel extends Model
{
    /**
     * @var \PDO Соединение с базой
     */
    private $db;

    /**
     * DbModel constructor.
     */
    public function __construct()
    {
        $this->db = Db::getConnection();
        parent::__construct();
    }

    /**
     * Возвращает название таблицы
     * @return string
     */
    abstract public function getTable();
}
