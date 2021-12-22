<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Route;

class SignedUrlController extends Controller
{
    public static function routes()
    {
        Route::prefix('signed_url')->middleware(['signed_url'])->group(function () {

            Route::get('/homologacao/{chamado_id}/mac{usuario_id}/email_url', [HomologacaoController::class, 'homologarEmailUrl'])
                ->name('homologacao_email_url');

        });
    }
}
