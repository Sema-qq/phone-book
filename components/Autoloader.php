<?php


namespace components;

/**
 * Автозагрузчик
 */
class Autoloader
{
    /**
     * Регистрирует автозагрузчик
     */
    public function register()
    {
        spl_autoload_register([$this, 'loader']);
    }

    /**
     * Подгружает классы
     * @param string $className Имя класса с неймспейсом
     */
    private function loader($className)
    {
        $filePath = ROOT . str_replace('\\','/', $className)  . '.php';

        if (file_exists($filePath)) {
            require_once $filePath;
        }
    }
}
