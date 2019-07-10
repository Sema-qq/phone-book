<?php

namespace extensions;

use system\instruments\FormModel;

class HtmlHelper
{
    /**
     * Возвращает картинку
     * @param string $image
     * @param bool $basePath
     */
    public static function getImage($image, $basePath = true)
    {
        $imagePath = $basePath ? "/templates/img/{$image}" : $image;
        echo "<img src='{$imagePath}'>";
    }

    /**
     * Возвращает html текстового инпута
     * @param FormModel $model модель
     * @param string $attribute атрибут
     * @param array $htmlOptions массив опций
     */
    public static function textInput($model, $attribute, $htmlOptions = [])
    {
        $htmlOptions['type'] = 'text';
        self::input($model, $attribute, $htmlOptions);
    }

    /**
     * Возвращает html инпута типа пароль
     * @param FormModel $model модель
     * @param string $attribute атрибут
     * @param array $htmlOptions массив опций
     */
    public static function passwordInput($model, $attribute, $htmlOptions = [])
    {
        $htmlOptions['type'] = 'password';
        self::input($model, $attribute, $htmlOptions);
    }

    /**
     * Генерирует html input
     * @param FormModel $model модель
     * @param string $attribute атрибут
     * @param array $htmlOptions массив опций
     */
    private static function input($model, $attribute, $htmlOptions = [])
    {
        $label = $model->getAttributeLabel($attribute);
        $id = isset($htmlOptions['id']) ? $htmlOptions['id'] : $attribute;
        $placeholder = isset($htmlOptions['placeholder']) ? $htmlOptions['placeholder'] : $label;

        if (isset($htmlOptions['required']) && $htmlOptions['required'] == true) {
            $label .= "<span class='required'> *</span>";
        }

        $htmlOptions = array_merge($htmlOptions, [
            'id' => $id,
            'name' => $attribute,
            'placeholder' => $placeholder
        ]);

        $content = "<label for='{$attribute}' class='form'>$label</label>";
        $content .= "<input value='{$model->$attribute}'";

        foreach ($htmlOptions as $attr => $value) {
            $content .= "{$attr}='{$value}' ";
        }
        $content .= ">";
        $content .= "<small id='{$attribute}' class='form-text text-error'>{$model->getError($attribute)}</small>";
        echo $content;
    }
}
