<?php

use Alkoumi\LaravelArabicNumbers\Numbers;

if (! function_exists('errorLog')) {
    function errorLog(Throwable $exception): void
    {
        logger()->info($exception->getMessage());
        logger()->info($exception->getTraceAsString());
    }
}

if (! function_exists('hindiNumbers')) {
    function hindiNumbers($string)
    {
        return strtr($string, ['0' => '٠', '1' => '١', '2' => '٢', '3' => '٣', '4' => '٤', '5' => '٥', '6' => '٦', '7' => '٧', '8' => '٨', '9' => '٩', '.' => ',']);
    }
}

if (! function_exists('camelToSnakeCase')) {
    function camelToSnakeCase(array $array): array
    {
        foreach ($array as $key => $value) {

            unset($array[$key]); // Unsetting keys

            $keyTrans = strtolower(preg_replace('/([a-z])([A-Z])/',
                '$1_$2', ltrim($key, '!')));
            $array[$keyTrans] = $value;
            if (is_array($value)) {
                $array[$keyTrans] = camelToSnakeCase($value);
            }
        }

        return $array;
    }
}
if (! function_exists('tafqeet')) {
    function tafqeet(int|float $number)
    {
        logger()->info($number);
        logger()->info(number_format($number, 2, ',', ''));

        return Numbers::TafqeetMoney(number_format($number, 2, '.', ''), 'EGP');
    }
}

if (! function_exists('convertArrayToUtf8')) {
    function convertArrayToUtf8($array)
    {
        // If it's not an array, return as is
        if (! is_array($array)) {
            return $array;
        }

        $utf8Array = [];

        foreach ($array as $key => $value) {
            // If the value is an array, recursively convert it
            if (is_array($value)) {
                $utf8Array[$key] = convertArrayToUtf8($value);
            } else {
                // If the value is a string, convert it to UTF-8
                $utf8Array[$key] = json_encode($value, JSON_UNESCAPED_UNICODE);
            }
        }

        return $utf8Array;
    }
}

if (! function_exists('userName')) {
    function userName()
    {
        if (auth()->check()) {
            return auth()->user()->name;
        }

        return '';
    }
}
