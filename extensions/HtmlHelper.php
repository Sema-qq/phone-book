<?php

namespace extensions;

use system\core\DbModel;
use system\core\Model;

class HtmlHelper
{
    /**
     * Возвращает картинку
     * @param string $image
     * @param bool $basePath
     * @param array $htmlOptions
     */
    public static function getImage($image, $basePath = true, array $htmlOptions = [])
    {
        $imagePath = $basePath ? "/templates/img/{$image}" : $image;

        $options = '';

        foreach ($htmlOptions as $attr => $value) {
            $options .= "{$attr}='{$value}' ";
        }

        $content = "<img src='{$imagePath}' {$options}>";

        echo $content;
    }

    /**
     * Выводит ошибки
     * @param Model $model
     * @param string $attribute
     */
    public static function errors($model, $attribute)
    {
        if ($message = $model->getError($attribute)) {
            self::alerts('danger', $message);
        }
    }

    /**
     * Выводит алерт
     * @param string $class
     * @param string $message
     */
    public static function alerts($class, $message)
    {
        echo "<div class='alert alert-{$class}' role='alert'>{$message}</div>";
    }

    /**
     * Возвращает html скрытого инпута
     * @param Model $model модель
     * @param string $attribute атрибут
     * @param array $htmlOptions массив опций
     */
    public static function hiddenInput($model, $attribute, $htmlOptions = [])
    {
        $htmlOptions['id'] = isset($htmlOptions['id']) ? $htmlOptions['id'] : $attribute;

        $content =  "<input type='hidden' name='{$attribute}' value='{$model->$attribute}' ";

        foreach ($htmlOptions as $attr => $value) {
            $content .= "{$attr}='{$value}' ";
        }

        $content .= ">";

        echo $content;

    }

    /**
     * Возвращает html текстового инпута
     * @param Model $model модель
     * @param string $attribute атрибут
     * @param array $htmlOptions массив опций
     */
    public static function textInput($model, $attribute, $htmlOptions = [])
    {
        if (!isset($htmlOptions['type'])) {
            $htmlOptions['type'] = 'text';
        }

        self::input($model, $attribute, $htmlOptions);
    }

    /**
     * Возвращает html инпута типа пароль
     * @param Model $model модель
     * @param string $attribute атрибут
     * @param array $htmlOptions массив опций
     */
    public static function passwordInput($model, $attribute, $htmlOptions = [])
    {
        $htmlOptions['type'] = 'password';
        self::input($model, $attribute, $htmlOptions);
    }

    /**
     * Возвращает html инпута загрузки файлов
     * @param Model $model модель
     * @param string $attribute атрибут
     * @param array $htmlOptions массив опций
     */
    public static function fileInput($model, $attribute, $htmlOptions = [])
    {
        $htmlOptions['type'] = 'file';
        self::input($model, $attribute, $htmlOptions);
    }

    /**
     * Генерирует html input
     * @param Model $model модель
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

        $content = "<label for='{$id}' class='form'>$label</label>";
        $content .= "<input value='{$model->$attribute}'";

        foreach ($htmlOptions as $attr => $value) {
            $content .= "{$attr}='{$value}' ";
        }
        $content .= ">";
        $content .= "<small id='{$attribute}' class='form-text text-error'>{$model->getError($attribute)}</small>";
        echo $content;
    }

    /**
     * @param Model $model
     * @param array $attributes
     */
    public static function tableView($model, $attributes = [])
    {
        $content = '<div class="row"><table class="table table-striped table-bordered detail-view"><tbody>';

        foreach ($attributes as $attribute) {
            $content .= "<tr><th>{$model->getAttributeLabel($attribute)}</th>";
            $content .= "<td>{$model->$attribute}</td></tr>";
        }

        $content .= '</tbody></table></div>';

        echo $content;
    }

    /**
     * @param DbModel[] $models
     * @param DbModel $class
     * @param array $attributes
     * @param array $sortAttributes
     * @param string $url
     */
    public static function tableIndex($models, $class, array $attributes, array $sortAttributes, $url)
    {
        $content = '<div class="row"><table class="table table-hover"><thead class="">';

        foreach ($attributes as $attribute) {
            if (in_array($attribute, $sortAttributes)) {
                $arraySort = ['DESC' => 'ASC', 'ASC' => 'DESC'];
                $sort = isset($_GET['sort']) && in_array($_GET['sort'], $arraySort) ? $arraySort[$_GET['sort']] : 'ASC';
                $content .= "<th><a href='/{$url}/index?sortAttr={$attribute}&sort={$sort}'>{$class->getAttributeLabel($attribute)}</a></th>";
            } else {
                $content .= "<th>{$class->getAttributeLabel($attribute)}</th>";
            }
        }

        $content .= '<th></th></thead><tbody>';

        /** @var DbModel $model */
        foreach ($models as $model) {
            $content .= '<tr>';

            foreach ($attributes as $attribute) {
                # todo костыль, ну а что поделать, время поджимает.
                if ($attribute == 'PHOTO') {
                    $image = "<img src='{$model->getImage()}' width='50'>";
                    $content .= "<td>{$image}</td>";
                } else {
                    $content .= "<td>{$model->$attribute}</td>";
                }
            }

            $content .= "<td><a href='/{$url}/view/{$model->{$model->primaryKey()}}' title='Просмотр' aria-label='Просмотр'>&#9787;</a>";
            $content .= "<a href='/{$url}/update/{$model->{$model->primaryKey()}}' title='Редактировать' aria-label='Редактировать'>&#9998;</a></td>";
        }

        $content .= '</tbody></table></div>';

        echo $content;
    }

    /**
     * Возвращает html captcha
     * @param Model $model модель
     * @param string $attribute атрибут
     * @param array $inputOptions массив опций для поля ввода
     * @param array $captchaOptions массив опций для картинки
     */
    public static function captcha($model, $attribute, $inputOptions = [], $captchaOptions = [])
    {
        $label = $model->getAttributeLabel($attribute);
        $id = isset($inputOptions['id']) ? $inputOptions['id'] : $attribute;
        $placeholder = isset($inputOptions['placeholder']) ? $inputOptions['placeholder'] : $label;

        if (isset($inputOptions['required']) && $inputOptions['required'] == true) {
            $label .= "<span class='required'> *</span>";
        }

        $inputOptions = array_merge($inputOptions, [
            'id' => $id,
            'name' => $attribute,
            'placeholder' => $placeholder
        ]);

        $content = "<label for='{$id}' class='form'>{$label}</label></div>";
        $content .= "<div class='row form-group'><div class='col'><img";

        foreach ($captchaOptions as $attr => $value) {
            $content .= " {$attr}='{$value}' ";
        }

        $content .= "></div><div class='col'><input";

        foreach ($inputOptions as $attr => $value) {
            $content .= " {$attr}='{$value}' ";
        }

        $content .= "><small id='{$id}' class='form-text text-error'>{$model->getError($attribute)}</small></div>";

        echo $content;
    }
}