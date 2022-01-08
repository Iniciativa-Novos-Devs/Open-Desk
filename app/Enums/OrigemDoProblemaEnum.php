<?php

namespace App\Enums;

class OrigemDoProblemaEnum
{
    public const OPERACIONAL    = 1;
    public const SISTEMA        = 2;
    public const EXTERNO        = 3;

    public static $humans        = [
        1 => 'Operacional',
        2 => 'Sistema',
        3 => 'Externo',
    ];

    public static function getValue(int $enum = null)
    {
        if($enum && self::isValidEnum($enum))
            return self::$humans[$enum] ?? null;

        return null;
    }

    public static function isValidEnum(int $enum)
    {
        return in_array($enum, array_keys(self::$humans));
    }
}
