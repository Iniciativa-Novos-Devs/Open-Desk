<?php

namespace App\Enums;

class OrigemDoProblemaEnum extends AbstractEnum
{
    public const OPERACIONAL = 1;

    public const SISTEMA = 2;

    public const EXTERNO = 3;

    public static $humans = [
        1 => 'Operacional',
        2 => 'Sistema',
        3 => 'Externo',
    ];
}
