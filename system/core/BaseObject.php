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
        } elseif (method_exists($this, 'get' . ucfirst($name))) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }

        throw new \Exception("Не найдено свойство {$this->getClass()}::\${$name}");
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }

        throw new \Exception("Не найдено свойство {$this->getClass()}::\${$name}");
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

        throw new \Exception("Не найден метод {$this->getClass()}::\${$name}()");
    }

    public function getClass()
    {
        return get_class($this);
    }
}
