<?php
/**
 * Created by PhpStorm.
 * User: truehueta
 * Date: 06.07.19
 * Time: 11:54
 */

namespace models;


use system\instruments\FormModel;

class ImageUpload extends FormModel
{
    public $image;

    /**
     * Возвращает ассоциативный массив соответствий,
     * где ключ это имя свойства дочернего класса,
     * а знаение - его наименование для отображения в форме
     * @return array
     */
    public function attributeLabels()
    {
        // TODO: Implement attributeLabels() method.
    }
}
