<?php


namespace system\core;

use PDO;
use PDOStatement;

/**
 * Базовый клас модели для работы с базой данных
 */
abstract class DbModel extends Model
{
    /** @var string Запрос в базу */
    private $_query;
    /** @var array Условия запроса */
    private $_where = [];
    /** @var array Условия сортировки */
    private $_sort;

    /**
     * Возвращает название таблицы
     * @return string
     */
    abstract public function getTable();

    /**
     * Возвращает primary key таблицы
     * @return string
     */
    abstract public function primaryKey();

    /**
     * Возвращает массив свойств-полей в таблице
     * @return array
     */
    abstract public function fields();

    /**
     * Подключение к дб
     * @return PDO|null
     */
    public static function getDb()
    {
        return Db::getConnection();
    }

    public static function find()
    {
        return new static();
    }

    public static function findAll()
    {
        return self::find()->all();
    }

    public static function findOne($pk)
    {
        return self::find()->one($pk);
    }

    public static function deleteOne($pk)
    {
        return self::find()->delete($pk);
    }

    public function save($validate = true)
    {
        if ($validate && !$this->validate()) {
            return false;
        }

        return $this->{$this->primaryKey()} ? $this->update() : $this->insert();
    }

    public function delete($pk = null)
    {
        if (!$pk) {
            $pk = $this->{$this->primaryKey()};
        }

        $this->_query = "DELETE FROM {$this->getTable()}";
        $this->_where = [$this->primaryKey() => $pk];

        return (bool)$this->execute();
    }

    /**
     * Добавляет условия
     * @param array $where
     * @return $this
     */
    public function where(array $where)
    {
        $this->_where = $where;
        return $this;
    }

    /**
     * Возвращает одну запись
     * @param int|null $pk primaryKey
     * @return null|DbModel
     */
    public function one($pk = null)
    {
        if ($pk) {
            $this->_where = [$this->primaryKey() => $pk];
        }

        $statement = $this->execute();
        return $statement ? $statement->fetchObject(get_class($this)) : null;
    }

    /**
     * Возвращает все записи
     * @return array|DbModel[]
     */
    public function all()
    {
        $statement = $this->execute();
        return $statement ? $statement->fetchAll(PDO::FETCH_CLASS, get_class($this)) : [];
    }

    /**
     * Добавляет сортировку
     * @param array $sort
     * @return $this
     */
    public function sort(array $sort)
    {
        $this->_sort = $sort;
        return $this;
    }

    /**
     * Подготавливает запрос
     */
    private function prepareQuery()
    {
        if (!$this->_query) {
            $this->_query = "SELECT * FROM {$this->getTable()} ";
        }

        if ($this->_where) {
            $this->_query .= ' WHERE ';
        }

        foreach (array_keys($this->_where) as $key => $name) {
            if ($key !== 0 && $key !== (count($this->_where))) {
                $this->_query .= ' AND ';
            }
            $this->_query .= "{$name} = :$name";
        }

        if ($this->_sort) {
            $this->_query .= ' ORDER BY ';
            foreach ($this->_sort as $field => $order) {
                $this->_query .= "{$field} $order";
            }
        }
    }

    /**
     * Создает запись
     * @return bool
     */
    private function insert()
    {
        $fields = $this->fields();

        $columns = implode(', ', $fields);

        $values = ':' . implode(', :', $fields);

        $this->_query = "INSERT INTO {$this->getTable()} ({$columns}) VALUES ({$values})";

        if ($this->execute($fields)) {
            $this->{$this->primaryKey()} = self::getDb()->lastInsertId();
            return true;
        }

        return false;
    }

    /**
     * Обновляет запись
     * @return bool
     */
    private function update()
    {
        $update = [];

        foreach ($this->fields() as $field) {
            $update[] = "{$field} = :{$field}";
        }

        $values = implode(', ', $update);

        $pk = $this->primaryKey();

        $this->_query = "UPDATE {$this->getTable()} SET {$values} WHERE {$pk} = :{$pk}";

        return (bool)$this->execute(array_merge($this->fields(), [$pk]));
    }

    /**
     * Выполняет запрос,
     * а так же подготавливает его и в случае ошибки,
     * устанавливает ошибку..
     * Что-то слишком много обязанностей для одного метода :(
     * @param array $fields
     * @return bool|PDOStatement
     */
    private function execute(array $fields = [])
    {
        $this->prepareQuery();

        $statement = self::getDb()->prepare($this->_query);

        foreach ($this->_where as $name => $value) {
            $statement->bindValue(":$name", $value);
        }

        foreach ($fields as $field) {
            $statement->bindValue(":{$field}", $this->$field);
        }

        if (!$statement->execute()) {
            $this->addError('ALL', implode('. ', $statement->errorInfo()));
            return false;
        }

        return $statement;
    }
}
