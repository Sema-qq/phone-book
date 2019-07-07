<?php

namespace system\core;

/**
 * Базовый гласс
 */
class BaseObject
{
    public function __construct(array $properties = [])
    {
        foreach ($properties as $name => $value) {
            $this->$name = $value;
        }
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        } elseif (method_exists($this, $name)) {
            return $this->$name();
        }

//        $class = get_class($this);
//        throw new \Exception("Не найдено свойство {$class}::\${$name}");
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return $this->$name($arguments);
        }

        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method($arguments);
        }

//        $class = get_class($this);
//        throw new \Exception("Не найден метод {$class}::\${$name}()");
    }
}