<?php

return [
    'show_versions' => env('SHOW_VERSIONS', true),

    'show_commit_date' => env('SHOW_COMMIT_DATE', (env('APP_ENV') !== 'production')),

    'show_versions_in_footer' => env('SHOW_VERSIONS_IN_FOOTER', true),
];
