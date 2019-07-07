<?php

use system\core\App;
use system\core\Autoloader;

try {
    ini_set('display_errors', 1);

    error_reporting(E_ALL);

    define('ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);

    require_once(ROOT . 'system/core/Autoloader.php');

    require_once(ROOT . 'system/core/base_functions.php');

    $config = require ROOT . 'config/config.php';

    Autoloader::register();
    App::start($config);
} catch (Exception $e) {
    dump($e->getMessage());
    dump($e->getTrace());
}
