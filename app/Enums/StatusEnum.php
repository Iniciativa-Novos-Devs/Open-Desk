<?php

namespace App\Enums;

class StatusEnum
{
    public const ABERTO         = 1;
    public const PENDENTE       = 2;
    public const EM_ATENDIMENTO = 3;
    public const TRANSFERIDO    = 4;
    public const PAUSADO        = 5;
    public const ENCERRADO      = 6;

    public static $humans        = [
        1 => 'Aberto',
        2 => 'Pendente',
        3 => 'Em atendimento',
        4 => 'Transferido',
        5 => 'Pausado',
        6 => 'Encerrado',
    ];

    public static function getState(int $state_enum)
    {
        if(self::isValidState($state_enum))
            return self::$humans[$state_enum];

        return null;
    }

    public static function isValidState(int $state_enum)
    {
        return in_array($state_enum, array_keys(self::$humans));
    }
}
