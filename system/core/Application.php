<?php

namespace system\core;

/**
 * Ядро приложения
 */
class Application
{
    /** @var object компоненты приложения */
    public static $app;
    /** @var array Массив конфигурации приложения */
    private $config;

    /**
     * Стартует приложение
     * @param array $config Конфигурация приложения
     */
    public function start($config)
    {
        session_start();

        $this->config = $config;
        $this->setApp();

        $router = new Router();
        $router->run();
    }

    /**
     * Заполняет компоненты приложения
     */
    private function setApp()
    {
        $array = [
            'session' => new Session(),
            'request' => new Request()
        ];

        $components = $this->getComponents();

        self::$app = (object) array_merge($array, $components);
    }

    /**
     * Создает объекты компонентов из конфига
     * @return array
     */
    private function getComponents()
    {
        $components = [];

        if (!empty($this->config['components'])) {
            foreach ((array) $this->config['components'] as $componentName => $params) {
                $class = !is_array($params) ? new $params() : null;
                if (!$class) {
                    $className = array_shift($params);
                    $class = new $className();
                    foreach ($params as $name => $value) {
                        $class->$name = $value;
                    }
                }
                $components[$componentName] = $class;
            }
        }

        return $components;
    }
}
