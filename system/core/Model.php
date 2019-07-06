<?php


namespace system\core;


class Model
{
    private $errors = [];

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
    }

    public function validateRules()
    {
        return [];
    }

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

    public function load($array)
    {
        foreach ((array)$array as $attribute => $value) {
            if (isset($this->$attribute)) {
                $this->$attribute = $value;
            }
        }
    }

    public function addError($attribute, $message)
    {
        $this->errors[$attribute] = $message;
    }

    public function getError($attribute)
    {
        return isset($this->errors[$attribute]) ? $this->errors[$attribute] : null;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
