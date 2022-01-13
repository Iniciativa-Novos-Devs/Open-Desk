<?php

return [
    /**
     * Se deve mostrar detalhes da versão baseada no commit
     */
    'show_versions' => env('SHOW_VERSIONS', true),

    /**
     * Se deve mostrar a hora do commit
     */
    'show_commit_date' => env('SHOW_COMMIT_DATE', (env('APP_ENV') !== 'production')),

    /**
     * Se deve mostrar a versão do commit no rodapé do site
     */
    'show_versions_in_footer' => env('SHOW_VERSIONS_IN_FOOTER', true),

    /**
     * Se deve utilizar a função exec() para obter a versão do git
     */
    'use_exec' => env('USE_EXEC', true),
];
