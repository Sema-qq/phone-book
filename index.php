<?php

use system\core\Application;
use system\core\Autoloader;

try {
    define('ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);

    require_once(ROOT . 'system/core/Autoloader.php');

    require_once(ROOT . 'system/core/base_functions.php');

    $config = require ROOT . 'config/config.php';

    Autoloader::register();
    Application::start($config);
} catch (Exception $e) {
    dump($e->getMessage());
    dump($e->getTrace());
}
