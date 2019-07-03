<?php

namespace extensions;

class Helper
{
    public static function dump($var)
    {
        echo '<pre>';
        var_dump($var);
        echo "\n";
    }

    public static function dd($var)
    {
        echo '<pre>';
        var_dump($var);
        die;
    }

    public static function getImage($image, $basePath = true)
    {
        $imagePath = $basePath ? "/templates/img/{$image}" : $image;
        echo "<img src='{$imagePath}'>";
    }
}
