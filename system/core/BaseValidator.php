<?php
/**
 * Created by PhpStorm.
 * User: truehueta
 * Date: 04.07.19
 * Time: 21:16
 */

namespace system\core;

/**
 * Базовый валидатор
 */
abstract class BaseValidator
{
    /**
     * Запускает валидацию
     * @param mixed $value Значение, которое будем валидировать
     * @return bool
     */
    abstract function validate($value);
}