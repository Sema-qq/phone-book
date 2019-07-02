<?php

use components\Autoloader;
//use components\Router;

try {
    ini_set('display_errors', 1);

    error_reporting(E_ALL);

    define('ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);

    require_once(ROOT . 'components/Autoloader.php');

    $loader = new Autoloader();
    $loader->register();

    $router = new components\Router();
    $router->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
