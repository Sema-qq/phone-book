<?php


namespace system\instruments;

use PDO;
use PDOStatement;
use system\core\Db;
use system\core\Model;

/**
 * Базовый клас модели для работы с базой данных
 */
abstract class DbModel extends Model
{
    /** @var PDO Соединение с базой */
    private $db;
    /** @var string Запрос в базу */
    private $query;
    /** @var array Условия запроса */
    private $where = [];
    /** @var array Условия сортировки */
    private $sort;

    /** @inheritdoc */
    public function __construct(array $properties = [])
    {
        $this->db = self::getDb();
        parent::__construct($properties);
    }

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

    public static function query()
    {
        return new static();
    }

    public static function findAll()
    {
        return self::query()->find()->all();
    }

    public static function findOne($pk)
    {
        return self::query()->find()->one($pk);
    }

    public function save($validate = true)
    {
        if ($validate && !$this->validate()) {
            return false;
        }

        return $this->primaryKey() ? $this->update() : $this->insert();
    }

    public function delete()
    {
        // удаление, если будет время
    }

    /**
     * Устанавливает начало запроса
     * @return $this
     */
    public function find()
    {
        $this->query = "SELECT * FROM {$this->getTable()} ";
        return $this;
    }

    /**
     * Добавляет условия
     * @param array $where
     * @return $this
     */
    public function where(array $where)
    {
        $this->where = $where;
        return $this;
    }

    /**
     * Возвращает одну запись
     * @param int|null $pk primaryKey
     * @return bool|DbModel
     */
    public function one($pk = null)
    {
        if ($pk) {
            $this->where = [$this->primaryKey() => $pk];
        }

        $statement = $this->execute();
        return $statement ? $statement->fetchObject(get_class($this)) : false;
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
     */
    public function sort(array $sort)
    {
        $this->sort = $sort;
    }

    /**
     * Подготавливает запрос
     */
    private function prepareQuery()
    {
        if ($this->where) {
            $this->query .= ' WHERE ';
        }

        foreach (array_keys($this->where) as $key => $name) {
            if ($key !== 0 && $key !== (count($this->where))) {
                $this->query .= ' AND ';
            }
            $this->query .= "{$name} = :$name";
        }

        if ($this->sort) {
            $this->query .= ' ORDER BY ';
            foreach ($this->sort as $field => $order) {
                $this->query .= "{$field} $order";
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

        $insertFields = implode(', ', $fields);

        $insertValues = ':' . implode(', :', $fields);

        $this->query = "INSERT INTO {$this->getTable()} ({$insertFields}) VALUES ({$insertValues})";

        if ($this->execute($fields)) {
            $this->{$this->primaryKey()} = $this->db->lastInsertId();
            return true;
        }

        return false;
    }

    /**
     * Обновляет запись
     * @return bool|PDOStatement
     */
    private function update()
    {
        $update = [];

        foreach ($this->fields() as $field) {
            $update[] = "{$field} = :{$field}";
        }

        $updateFields = implode(', ', $update);

        $pk = $this->primaryKey();

        $this->query = "UPDATE {$this->getTable()} SET {$updateFields} WHERE {$pk} = :{$pk}";

        return $this->execute(array_merge($this->fields(), [$pk]));
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

        $statement = $this->db->prepare($this->query);

        foreach ($this->where as $name => $value) {
            $statement->bindValue(":$name", $value);
        }

        foreach ($fields as $field) {
            $statement->bindValue(":{$field}", $this->$field);
        }

        if (!$statement->execute()) {
            $this->addError('ALL', $statement->errorInfo());
            return false;
        }

        return $statement;
    }
}
