<?php

return [
    'site_title' => env('APP_NAME', 'Help Desk'),

    //URL assinada para homologação de chamado
    'signed_url' => [
        'expires_in_minutes' => (int) env('SIGNED_URL_EXPIRES_IN_MINUTES', 8600),
    ],
];
