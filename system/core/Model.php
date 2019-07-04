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

    public function validate()
    {

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
