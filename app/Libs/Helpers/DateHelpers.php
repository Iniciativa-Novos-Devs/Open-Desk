<?php

namespace App\Libs\Helpers;

class DateHelpers
{
    public static function dateFormat($date, string $date_format)
    {
        if (! $date || ! self::isRealDate($date)) {
            return null;
        }

        return date($date_format, strtotime($date));
    }

    public static function isRealDate($date, string $date_format = 'Y-m-d H:i:s')
    {
        try {
            $time = strtotime($date);

            return ((bool) $time) ? true : false;
        } catch (\Throwable $th) {
            return false;
        }

        return false;
    }
}
