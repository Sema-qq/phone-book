<?php


namespace system\instruments;

use system\core\Model;

/**
 * Базовый класс модели для работы с формой
 */
abstract class FormModel extends Model
{
    /**
     * Возвращает ассоциативный массив соответствий,
     * где ключ это имя свойства дочернего класса,
     * а знаение - его наименование для отображения в форме
     * @return array
     */
    abstract public function attributeLabels();

    /**
     * Возвращает label атрибута
     * @param string $attribute Имя атрибута
     * @return mixed
     */
    public function getAttributeLabel($attribute)
    {
        $label = $attribute;

        if (isset($this->attributeLabels()[$attribute])) {
            $label = $this->attributeLabels()[$attribute];
        }

        return $label;
    }
}
