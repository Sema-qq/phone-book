<?php

use system\core\Application;
use system\core\Autoloader;

ini_set('display_errors', 1);

error_reporting(E_ALL);

define('ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);

require_once(ROOT . 'system/core/Autoloader.php');

$config = require ROOT . 'config/config.php';

Autoloader::register();

$app = new Application();
$app->start($config);
