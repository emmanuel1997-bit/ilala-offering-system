<?php

namespace App\Helpers;

class NumberToWords
{
    protected static $units = [
        0 => 'sifuri',
        1 => 'moja',
        2 => 'mbili',
        3 => 'tatu',
        4 => 'nne',
        5 => 'tano',
        6 => 'sita',
        7 => 'saba',
        8 => 'nane',
        9 => 'tisa',
        10 => 'kumi',
        11 => 'kumi na moja',
        12 => 'kumi na mbili',
        13 => 'kumi na tatu',
        14 => 'kumi na nne',
        15 => 'kumi na tano',
        16 => 'kumi na sita',
        17 => 'kumi na saba',
        18 => 'kumi na nane',
        19 => 'kumi na tisa',
    ];

    protected static $tens = [
        2 => 'ishirini',
        3 => 'thelathini',
        4 => 'arobaini',
        5 => 'hamsini',
        6 => 'sitini',
        7 => 'sabini',
        8 => 'themanini',
        9 => 'tisini',
    ];

    public static function convert($number)
    {
        $number = (int)$number;

        if ($number < 20) {
            return self::$units[$number];
        }

        if ($number < 100) {
            $tens = (int)($number / 10);
            $unit = $number % 10;
            return self::$tens[$tens] . ($unit ? ' na ' . self::$units[$unit] : '');
        }

        if ($number < 1000) { // hundreds
            $hundreds = (int)($number / 100);
            $remainder = $number % 100;
            $words =  'mia '.($hundreds >= 1 ? self::$units[$hundreds] . ' ' : '') ;
            if ($remainder) {
                $words .= ' ' . self::convert($remainder);
            }
            return $words;
        }

        if ($number < 100000) { // thousands
            $thousands = (int)($number / 1000);
            $remainder = $number % 1000;
            $words = 'elfu '.($thousands >= 1 ? self::convert($thousands) . ' ' : '') ;
            if ($remainder) {
                $words .= ' ' . self::convert($remainder);
            }
            return $words;
        }

        if ($number < 1000000) { // hundred-thousands
            $lakh = (int)($number / 100000);
            $remainder = $number % 100000;
            $words = 'laki '.($lakh >= 1 ? self::convert($lakh) . ' ' : '') ;
            if ($remainder) {
                $words .= ' ' . self::convert($remainder);
            }
            return $words;
        }

        if ($number <= 1000000000) { // millions up to 20M
            $millions = (int)($number / 1000000);
            $remainder = $number % 1000000;
            $words = 'milioni '.($millions >= 1 ? self::convert($millions) . ' ' : '') ;
            if ($remainder) {
                $words .= ' ' . self::convert($remainder);
            }
            return $words;
        }

        return (string)$number;
    }
}
