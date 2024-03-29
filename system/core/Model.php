<?php


namespace system\core;


use models\traits\BaseValidators;

class Model extends BaseObject
{
    use BaseValidators;

    /** @var array Массив ошибок */
    private $_errors = [];

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
        return [
//            [['login'], 'validateLogin'],
//            [['password'], 'validatePassword']
        ];
    }

    /**
     * Валидирует свойства объекта
     * @return bool
     */
    public function validate()
    {
        foreach ((array)$this->validateRules() as $validateRow) {
            # todo: рассмотреть варианты, когда правила валидации заполнены не правильны
            $attributes = array_shift($validateRow);
            $validateMethod = array_shift($validateRow);

            foreach ((array)$attributes as $attribute) {
                $this->$validateMethod($attribute);
            }
        }

        return (bool)!$this->getErrors();
    }

    /**
     * Заполняет свойства объекта из массива
     * @param array $array
     */
    public function load($array)
    {
        foreach ((array)$array as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->$attribute = $value;
            }
        }
    }

    /**
     * Возвращает ассоциативный массив соответствий,
     * где ключ это имя свойства дочернего класса,
     * а знаение - его наименование для отображения в форме
     * @return array
     */
    public function attributeLabels()
    {
        return [
//            'name' => 'Имя пользователя'
        ];
    }

    /**
     * Возвращает label атрибута
     * @param string $attribute Имя атрибута
     * @return mixed
     */
    public function getAttributeLabel($attribute)
    {
        $label = $attribute;

        if (isset($this->attributeLabels()[$attribute]) || array_key_exists($attribute, $this->attributeLabels())) {
            $label = $this->attributeLabels()[$attribute];
        }

        return $label;
    }

    /**
     * Добавляет ошибку
     * @param string $attribute
     * @param string $message
     */
    public function addError($attribute, $message)
    {
        $this->_errors[$attribute] = $message;
    }

    /**
     * Возвращает ошибку атрибута
     * @param string $attribute Имя атрибута
     * @return string|null
     */
    public function getError($attribute)
    {
        return isset($this->_errors[$attribute]) ? $this->_errors[$attribute] : null;
    }

    /**
     * Возвращает массив ошибок
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }
}
