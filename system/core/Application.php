<?php

namespace system\core;

use extensions\Helper;

class Application
{
    public static $app;

    public function start($config)
    {
        session_start();

        $this->setApp($config);

        $router = new Router();
        $router->run();
    }

    private function setApp($config)
    {
        $array = [
            'session' => new Session(),
            'request' => new Request()
        ];

        if (!empty($config['components'])) {
            foreach ((array) $config['components'] as $componentName => $className) {
                $array[$componentName] = new $className();
            }
        }

        self::$app = (object) $array;
    }
}
