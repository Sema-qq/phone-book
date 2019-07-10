<?php

namespace models\traits;

trait BaseValidators
{
    public function validateRequired($attribute)
    {
        if (!$this->$attribute) {
            $this->addError($attribute, "Поле \"{$this->getAttributeLabel($attribute)}\" не заполнено.");
        }
    }
}
