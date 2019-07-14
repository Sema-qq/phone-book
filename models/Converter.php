<?php

namespace models;


class Converter
{
    /** @var array Цифры */
    private $numbers = [];
    /** @var array Порядки */
    private $orders = [];
    /** @var array Карта */
    private $map = [];

    /**
     * Конвертирует число в строку
     * @param string $string
     * @return string
     */
    public static function convert($string)
    {
        $number = preg_replace('/[^0-9]/', '', $string);

        if (strlen($number) > 12) {
            return 'Максимум 12 цифр';
        } elseif ($number == 0) {
            return 'Ноль';
        } elseif (!$number) {
            return 'Цифры отсутствуют.';
        }

        $model = new self();

        return $model->run($number);
    }

    /** Наполняет свойства для удобства */
    public function __construct()
    {
        $this->numbers = $this->getDictionaryNumbers();
        $this->orders = $this->getDictionaryOrders();
        $this->map = $this->getMap();
    }

    /**
     * Выполняет основной код конвертации
     * @param int $number
     * @return string
     */
    private function run($number)
    {
        $result = [];

        $parts = $this->getParts($number);

        foreach ($parts as $i => $part) {
            if ($part > 0) {
                $numerals = [];

                if ($part > 99) {
                    $numerals[] = floor($part / 100) * 100;
                }

                if ($mod1 = $part % 100) {
                    $mod2 = $part % 10;
                    $flag = ($i == 1 && $mod1 != 11 && $mod1 != 12 && $mod2 < 3) ? -1 : 1;

                    if ($mod1 < 20 || !$mod2) {
                        $numerals[] = $flag * $mod1;
                    } else {
                        $numerals[] = floor($mod1 / 10) * 10;
                        $numerals[] = $flag * $mod2;
                    }
                }

                $last = abs(end($numerals));

                foreach ($numerals as $j => $digit) {
                    $numerals[$j] = $this->numbers[$digit];
                }

                $numerals[] = $this->orders[$i][(($last %= 100) > 4 && $last < 20) ? 2 : $this->map[min($last % 10, 5)]];

                array_unshift($result, implode(' ', $numerals));
            }
        }

        return implode(' ', $result);
    }

    /**
     * Разбивает число в массив
     * @param int $number
     * @return array
     */
    private function getParts($number)
    {
        $prepareNumber = str_pad($number, ceil(strlen($number) / 3) * 3, 0, STR_PAD_LEFT);
        return array_reverse(str_split($prepareNumber, 3));
    }

    /**
     * Возвращает массив цифр соответствий
     * @return array
     */
    private function getDictionaryNumbers()
    {
        return [
            -2 => 'две',
            -1 => 'одна',
            1 => 'один',
            2 => 'два',
            3 => 'три',
            4 => 'четыре',
            5 => 'пять',
            6 => 'шесть',
            7 => 'семь',
            8 => 'восемь',
            9 => 'девять',
            10 => 'десять',
            11 => 'одиннадцать',
            12 => 'двенадцать',
            13 => 'тринадцать',
            14 => 'четырнадцать',
            15 => 'пятнадцать',
            16 => 'шестнадцать',
            17 => 'семнадцать',
            18 => 'восемнадцать',
            19 => 'девятнадцать',
            20 => 'двадцать',
            30 => 'тридцать',
            40 => 'сорок',
            50 => 'пятьдесят',
            60 => 'шестьдесят',
            70 => 'семьдесят',
            80 => 'восемьдесят',
            90 => 'девяносто',
            100 => 'сто',
            200 => 'двести',
            300 => 'триста',
            400 => 'четыреста',
            500 => 'пятьсот',
            600 => 'шестьсот',
            700 => 'семьсот',
            800 => 'восемьсот',
            900 => 'девятьсот'
        ];
    }

    /**
     * Возвращает массив порядков со склонениями
     * @return array
     */
    private function getDictionaryOrders()
    {
        return [
            ['', '', ''],
            ['тысяча', 'тысячи', 'тысяч'],
            ['миллион', 'миллиона', 'миллионов'],
            ['миллиард', 'миллиарда', 'миллиардов'],
            ['триллион', 'триллиона', 'триллионов'],
            ['квадриллион', 'квадриллиона', 'квадриллионов']
        ];
    }

    /**
     * Возвращает массив карту
     * @return array
     */
    private function getMap()
    {
        return [2, 0, 1, 1, 1, 2];
    }
}