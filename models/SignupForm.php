<?php


namespace models;


use system\instruments\FormModel;

class SignupForm extends FormModel
{

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
    
    public function save()
    {
        
    }
}
