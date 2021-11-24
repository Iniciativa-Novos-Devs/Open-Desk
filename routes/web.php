<?php

use Illuminate\Http\Request;

use App\Http\Controllers\PainelController;

use App\Http\Controllers\ValidadorCpsUsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PainelController::class, 'index']);
Route::get('/dashboard', [PainelController::class, 'index'])->name('dashboard');

##-----------------------------------------------------------------------------------
/**
 * TODAS AS ROTAS DO PAINEL
 * /painel/*
 */
PainelController::routes();
##-----------------------------------------------------------------------------------

Route::group(['middleware' => ['redirect_to_base_host']], function () {
    require __DIR__.'/auth.php';
});

Route::get('/register', function(){
    return redirect()->route('login')->with('error', 'Acesso não autorizado!');
});

//URL assinadas (login automático por URL)
\App\Http\Controllers\SignedUrlController::routes();

//Para testes em dev
\App\Http\Controllers\Dev\DevTestsRouteController::routes();
