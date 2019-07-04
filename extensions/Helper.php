<?php

namespace extensions;

class Helper
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
}
