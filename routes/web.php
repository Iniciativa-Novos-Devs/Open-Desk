<?php

use Illuminate\Http\Request;

use App\Http\Controllers\PainelController;
use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

##-----------------------------------------------------------------------------------
Route::group(['middleware' => ['redirect_to_base_host']], function () {
    require __DIR__.'/auth.php';
});

Route::get('/', [PainelController::class, 'index']);
Route::get('/dashboard', [PainelController::class, 'index'])->name('dashboard');

##-----------------------------------------------------------------------------------
/**
 * TODAS AS ROTAS DO PAINEL
 * /painel/*
 */
PainelController::routes();

##-----------------------------------------------------------------------------------
//Rotas redirecionadas para o login e outros endpoints
RedirectController::routes();

//URL assinadas (login automático por URL)
\App\Http\Controllers\SignedUrlController::routes();

//Para testes em dev
\App\Http\Controllers\Dev\DevTestsRouteController::routes();
