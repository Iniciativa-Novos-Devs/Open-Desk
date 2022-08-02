<?php

namespace App\Enums;

abstract class AbstractEnum
{
    public static $humans = [];

    public static function getValue(int $state_enum)
    {
        if (static::isValidState($state_enum)) {
            return static::$humans[$state_enum];
        }

        return null;
    }

    public static function isValidState(int $state_enum)
    {
        return in_array($state_enum, array_keys(static::$humans));
    }
}
