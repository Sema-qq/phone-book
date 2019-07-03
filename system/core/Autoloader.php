<?php


namespace system\core;

/**
 * Автозагрузчик
 */
class Autoloader
{
    /**
     * Регистрирует автозагрузчик
     */
    public static function register()
    {
        spl_autoload_register([self::class, 'loader']);
    }

    /**
     * Подгружает классы
     * @param string $className Имя класса с неймспейсом
     */
    private static function loader($className)
    {
        $filePath = ROOT . str_replace('\\','/', $className)  . '.php';

        if (file_exists($filePath)) {
            require_once $filePath;
        }
    }
}
