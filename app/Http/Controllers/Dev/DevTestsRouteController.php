<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ValidadorCpsUsuarioController;
use Route;

class DevTestsRouteController extends Controller
{
    public static function routes()
    {
        if (config('app.env') == 'local') {
            Route::prefix('dev')->group(function () {
                //Testes do Alpine
                \App\Http\Controllers\Dev\AlpineTestsController::routes();

                Route::get('fake-cps', [ValidadorCpsUsuarioController::class, 'fakeCpsResponse'])->name('fake_url_valida_usuario_cps');
                Route::get('valida-cps', [ValidadorCpsUsuarioController::class, 'secondLogin'])->middleware('auth')->name('valida_usuario_cps');
                Route::post('valida-cps', [ValidadorCpsUsuarioController::class, 'validateCpsUser'])->middleware('auth');

                Route::get('teste', function () {
                    return Auth::user()->name;
                })->middleware(['auth']);
            });
        }
    }
}
