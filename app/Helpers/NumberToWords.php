<?php

namespace App\Helpers;

class NumberToWords
{
    private static $numberToWords = [
        0 => 'nol', 1 => 'satu', 2 => 'dua', 3 => 'tiga', 4 => 'empat', 5 => 'lima',
        6 => 'enam', 7 => 'tujuh', 8 => 'delapan', 9 => 'sembilan', 10 => 'sepuluh',
        11 => 'sebelas', 12 => 'dua belas', 13 => 'tiga belas', 14 => 'empat belas',
        15 => 'lima belas', 16 => 'enam belas', 17 => 'tujuh belas', 18 => 'delapan belas',
        19 => 'sembilan belas'
    ];

    private static $units = [
        20 => 'dua puluh', 30 => 'tiga puluh', 40 => 'empat puluh', 50 => 'lima puluh',
        60 => 'enam puluh', 70 => 'tujuh puluh', 80 => 'delapan puluh', 90 => 'sembilan puluh'
    ];

    private static $terbilangUnits = [
        'ratus', 'ribu', 'juta', 'miliar', 'triliun'
    ];

    public static function toWords($number)
    {
        if (!is_numeric($number)) {
            return '';
        }

        $number = abs((int) $number);
        $words = [];

        if ($number < 20) {
            return self::$numberToWords[$number];
        }

        if ($number < 100) {
            $ten = floor($number / 10) * 10;
            $one = $number % 10;
            $result = self::$units[$ten];
            if ($one > 0) {
                $result .= ' ' . self::$numberToWords[$one];
            }
            return $result;
        }

        if ($number < 1000) {
            $hundred = floor($number / 100);
            $rest = $number % 100;
            $result = self::$numberToWords[$hundred] . ' ratus';
            if ($rest > 0) {
                $result .= ' ' . self::toWords($rest);
            }
            return $result;
        }

        if ($number < 1000000) {
            $thousand = floor($number / 1000);
            $rest = $number % 1000;
            $result = self::toWords($thousand) . ' ribu';
            if ($rest > 0) {
                $result .= ' ' . self::toWords($rest);
            }
            return $result;
        }

        // Add more logic for million, billion, etc. if needed
        return '';
    }
}