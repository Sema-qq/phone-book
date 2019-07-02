<?php


namespace components;

/**
 * Базовый класс контроллер
 */
class Controller
{
    /** @var string Дефолтный экшн */
    protected $defaultAction = 'index';

    /**
     * Возвращает представление
     */
    protected function render()
    {

    }

    /**
     * Перенаправляет на указанный экшн
     */
    protected function redirect()
    {

    }
}
