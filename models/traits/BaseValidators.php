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

    public function validateSymbol($attribute)
    {
        if (true) {
            $this->addError($attribute, "Символы /*+.,\|№!@#$;%:^?&()={}[]<> нельзя использовать.");
        }
    }
}
