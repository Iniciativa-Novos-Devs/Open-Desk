<?php

use App\Http\Controllers\Admin\PainelController;
use App\Http\Controllers\Admin\RedirectController;
use App\Http\Controllers\Admin\SignedUrlController;
use App\Http\Controllers\Dev\DevTestsRouteController;
use Illuminate\Support\Facades\Route;

//#-----------------------------------------------------------------------------------
Route::group(['middleware' => ['redirect_to_base_host']], function () {
    require __DIR__.'/auth.php';
});

Route::get('/', [PainelController::class, 'index'])->name('painel');

//#-----------------------------------------------------------------------------------
/**
 * TODAS AS ROTAS DO PAINEL
 * /painel/*
 */
PainelController::routes();

//#-----------------------------------------------------------------------------------
//Rotas redirecionadas para o login e outros endpoints
RedirectController::routes();

//URL assinadas (login automático por URL)
SignedUrlController::routes();

//Para testes em dev
DevTestsRouteController::routes();
