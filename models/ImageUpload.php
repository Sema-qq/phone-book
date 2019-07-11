<?php

namespace models;


use SplFileInfo;
use system\core\Model;

/**
 * Класс для загрузки изображений
 */
class ImageUpload extends Model
{
    /** Максимальный размер файла, который будем пропускать */
    const MAX_FILE_SIZE = 2097152;

    /** @var  string Поле для валидации на фронте */
    public $image;
    /** @var  string Имя файла при загрузке */
    public $name;
    /** @var  string Тип файла */
    public $type;
    /** @var  string Имя временного файла */
    public $tmp_name;
    /** @var  int Код ошибки */
    public $error;
    /** @var  int Размер файла в байтах */
    public $size;
    /** @var  SplFileInfo */
    private $_fileInfo;

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'image' => 'Фото'
        ];
    }

    /** @inheritdoc */
    public function validate()
    {
        if ($this->error) {
            $this->addError('image', "Ошибка при загрузке файла: {$this->error}");
        } elseif (!$this->name) {
            $this->addError('image', 'Не удалось получить имя файла.');
        } elseif (!in_array($this->_fileInfo->getExtension(), ['jpg', 'png'])) {
            $this->addError('image', 'Разрешен тип фото только "png" или "jpg".');
        } elseif ($this->size > self::MAX_FILE_SIZE) {
            $this->addError('image', 'Размер файла не больше двух мегабайт.');
        }

        return (bool)!$this->getErrors();
    }

    /**
     * Загружает картинку
     * @param string $currentImage Имя текущей фотографии
     * @return bool|string
     */
    public function imageUpload($currentImage)
    {
        $this->_fileInfo = new SplFileInfo($this->name);

        if ($this->validate()) {
            if ($currentImage) {
                $this->deleteCurrentImage($currentImage);
            }

            return $this->saveImage();
        }
        return false;
    }

    /**
     * Удаляет изображение
     * @param string $currentImage
     */
    private function deleteCurrentImage($currentImage)
    {
        if ($this->fileExists($currentImage)) {
            unlink($this->getFolder() . $currentImage);
        }
    }

    /**
     * Проверяет существование изображения
     * @param string $image
     * @return bool
     */
    private function fileExists($image)
    {
        return file_exists($this->getFolder() . $image);
    }

    /**
     * Возвращает директорию хранения изображений
     * @return string
     */
    private function getFolder()
    {
        return ROOT . 'templates/uploads/';
    }

    /**
     * Генерирует имя файла, чтобы не заменить чужую картинку
     * @return string
     */
    private function generateFilename()
    {
        $ext = $this->_fileInfo->getExtension();
        return strtolower(md5(uniqid(basename($this->name, $ext))) . '.' . $ext);
    }

    /** 
     * Сохраняет изображение в папке загрузок 
     */
    private function saveImage()
    {
        $filename = $this->generateFilename();

        return copy($this->tmp_name, $filename) && $this->fileExists($filename) ? $filename : false;
    }

}
