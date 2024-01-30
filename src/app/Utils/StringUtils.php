<?php

namespace App\Utils;


class StringUtils
{
    public static function isEmpty($string): bool
    {
        return $string === null || trim($string) === '';
    }
}

