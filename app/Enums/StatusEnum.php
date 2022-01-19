<?php

namespace App\Enums;

class StatusEnum extends AbstractEnum
{
    public const ABERTO         = 1;
    public const PENDENTE       = 2;
    public const EM_ATENDIMENTO = 3;
    public const TRANSFERIDO    = 4;
    public const PAUSADO        = 5;
    public const ENCERRADO      = 6;
    public const EM_HOMOLOGACAO = 7;
    public const HOMOLOGADO     = 8;

    public static $humans        = [
        1 => 'Aberto',
        2 => 'Pendente',
        3 => 'Em atendimento',
        4 => 'Transferido',
        5 => 'Pausado',
        6 => 'Encerrado',
        7 => 'Em homologação',
        8 => 'Homologado',
    ];
}
