<?php

use system\core\App;
use system\core\Autoloader;
use system\core\Controller;

try {
    ini_set('display_errors', 1);
    ini_set('file_uploads', 1);
    ini_set('upload_max_filesize', '2M');
    error_reporting(E_ALL);

    define('ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);

    require_once(ROOT . 'system/core/Autoloader.php');

    require_once(ROOT . 'system/core/base_functions.php');

    $config = require ROOT . 'config/config.php';

    Autoloader::register();
    App::start($config);
} catch (Exception $e) {
    $controller = new Controller();
    $controller->showError($e->getMessage());
}
