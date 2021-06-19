<?php

return [
    'email' => [
        /*
        |--------------------------------------------------------------------------
        | Entrega e-mails
        |--------------------------------------------------------------------------
        | Se deve enviar os e-mails dos chamados
        |
        */
        'delivery_emails' => env('TICKET_DELIVERY_EMAIL', true),
    ]
];
