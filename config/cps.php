<?php

return [

    /********************************
    | Se a validação no CPS está ativa
    /********************************/
    "enabled"    => env('CPS_ENABLED', true),

    /********************************
    | URL para fazer a requisição e validar se o usuário pode prosseguir com o login
    /********************************/
    "cps_auth_url"    => env('CPS_AUTH_URL'),

    /********************************
    | Método HTTP para fazer a requisição
    /********************************/
    "cps_auth_method"    => env('CPS_AUTH_METHOD', 'GET'),

    /********************************
    | Valor padrão em caso de falha na requisição
    | Falha HTTP não negação. Exemplo código 50x
    /********************************/
    "cps_auth_default_value"    => env('CPS_AUTH_DEFAULT_VALUE', false),

    /********************************
    | Tempo máximo de espera ao fazer uma requisição
    /********************************/
    "cps_request_timeout"    => env('CPS_REQUEST_TIMEOUT', 15),

    /********************************
    | Se permite login de administrador da aplicaão sem passar pela segunda validação
    /********************************/
    "allow_admin_without_2f"    => env('CPS_ALLOW_ADMIN_WITHOUT_2F', true),
];
