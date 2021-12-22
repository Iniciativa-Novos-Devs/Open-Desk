<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Route;

class RedirectController extends Controller
{
    public static function routes()
    {
        ##-----------------------------------------------------------------------------------
        ## Rotas de Auth desabilitadas
        Route::match(['GET', 'POST'], '/register', [self::class, 'disabledRedirectToLogin'])->name('register');
        Route::get('/forgot-password',             [self::class, 'disabledRedirectToLogin'])->name('password.request');
        Route::post( '/forgot-password',           [self::class, 'disabledRedirectToLogin'])->name('password.email');

        ##-----------------------------------------------------------------------------------
        ## Outras rotas redirecionadas
    }

    /**
     * function disabledRedirectToLogin
     *
     * @param Request $request
     */
    public function disabledRedirectToLogin(Request $request)
    {
        return redirect()->route('login')->with('error', 'Acesso inválido!');
    }
}
