<?php


namespace system\core;


class Model extends BaseObject
{
    /** @var array Массив ошибок */
    private $errors = [];

    /** @inheritdoc */
    public function __construct(array $properties = [])
    {
        $this->init();
        parent::__construct($properties);
    }

    /**
     * Инициализирует объект
     */
    public function init()
    {
    }

    /**
     * Возвращает массив правил валидации
     * @return array
     */
    public function validateRules()
    {
        return [];
    }

    /**
     * Валидирует свойства объекта
     * @return bool
     */
    public function validate()
    {
        foreach ((array)$this->validateRules() as $validateRow) {
            foreach ((array)$validateRow as $attributes => $validateMethod) {
                foreach ((array)$attributes as $attribute) {
                    if (!isset($this->$attribute)) {
                        $this->addError('ALL', "Не найдено свойство \"{$attribute}\" в классе.");
                        return false;
                    } elseif (!method_exists($this, $validateMethod)) {
                        $class = get_class($this);
                        $this->addError('ALL', "Не найден валидатор \"{$validateMethod}\" в \"{$class}\".");
                        return false;
                    } elseif (!$this->$validateMethod($attribute)) {
                        # устанавливать текст ошибки будет в методах
                        return false;
                    }
                }
            }
        }
        return true;
    }

    /**
     * Заполняет свойства объекта из массива
     * @param array $array
     */
    public function load($array)
    {
        foreach ((array)$array as $attribute => $value) {
            if (isset($this->$attribute)) {
                $this->$attribute = $value;
            }
        }
    }

    /**
     * Добавляет ошибку
     * @param string $attribute
     * @param string $message
     */
    public function addError($attribute, $message)
    {
        $this->errors[$attribute] = $message;
    }

    /**
     * Возвращает ошибку атрибута
     * @param string $attribute Имя атрибута
     * @return string|null
     */
    public function getError($attribute)
    {
        return isset($this->errors[$attribute]) ? $this->errors[$attribute] : null;
    }

    /**
     * Возвращает массив ошибок
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
