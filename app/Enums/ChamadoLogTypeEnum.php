<?php

namespace App\Enums;

class ChamadoLogTypeEnum extends AbstractEnum
{
    public const NAO_IDENTIFICADO           = 0;
    public const ATENDIMENTO_INICIADO       = 1;
    public const TRANSFERIDO                = 2;
    public const PAUSADO                    = 3;
    public const ENCERRADO                  = 4;
    public const ENVIADO_PARA_HOMOLOGAÇÃO   = 5;
    public const RETORNO_DA_HOMOLOGAÇÃO     = 6;
    public const HOMOLOGADO                 = 7;

    public static $humans        = [
        1 => 'Não identificado',
        1 => 'Atendimento iniciado',
        2 => 'Transferido',
        3 => 'Pausado',
        4 => 'Encerrado',
        5 => 'Enviado para homologação',
        6 => 'Retorno da homologação',
        7 => 'Homologado',
    ];
}
