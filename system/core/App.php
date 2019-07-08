<?php

namespace system\core;

/**
 * Ядро приложения
 */
class App
{
    /** @var object компоненты приложения */
    public static $components;
    /** @var array Массив конфигурации приложения */
    private $_config;

    /**
     * Стартует приложение
     * @param array $config Конфигурация приложения
     */
    public static function start($config)
    {
        session_start();

        $app = new self;

        $app->_config = $config;
        $app->setApp();

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

        self::$components = (object) array_merge($array, $components);
    }

    /**
     * Создает объекты компонентов из конфига
     * @return array
     */
    private function getComponents()
    {
        $components = [];

        if (!empty($this->_config['components'])) {
            foreach ((array) $this->_config['components'] as $componentName => $params) {
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

        $this->prepareUser($components);

        return $components;
    }

    /**
     * Если пользователь авторизован, то заполним его в компонентах
     * @param $components
     */
    private function prepareUser(&$components)
    {
        if (isset($components['user'])) {
            $sessionUser = isset($_SESSION['user']) ? $_SESSION['user'] : null;
            if ($sessionUser) {
                $components['user'] = $sessionUser;
            }
        }

//        if (isset(self::$components->user) && !self::$components->session->isGuest()) {
//            self::$components->user = self::$components->session->get('user');
//        }
    }
}
