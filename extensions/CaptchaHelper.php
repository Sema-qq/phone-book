<?php
namespace extensions;


class CaptchaHelper
{
    public static function createImage($text, $font)
    {
        $img = imagecreatetruecolor(200, 40);

        $white = imagecolorallocate($img, 255, 255, 255);
        $grey = imagecolorallocate($img, 150, 150, 150);
        $black = imagecolorallocate($img, 0, 0, 0);

        imagefilledrectangle($img, 0, 0, 200, 40, $white);
        imagettftext($img, 20, 4, 22, 30, $grey, $font, $text);
        imagettftext($img, 20, 4, 15, 32, $black, $font, $text);

        return $img;
    }

    public static function getText()
    {
        $signs = [
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
            'A', 'a', 'B', 'b', 'C', 'c', 'D', 'd', 'E', 'e',
            'F', 'f', 'G', 'g', 'H', 'h', 'I', 'i', 'J', 'j',
            'K', 'k', 'L', 'l', 'M', 'm', 'N', 'n', 'O', 'o',
            'P', 'p', 'Q', 'q', 'R', 'r', 'S', 's', 'T', 't',
            'U', 'u', 'V', 'v', 'W', 'w', 'Z', 'z', 'Y', 'y',
            'X', 'x'
        ];

        return implode('',array_rand(array_flip($signs), 6));
    }
}