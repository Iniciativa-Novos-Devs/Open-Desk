<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('menuPrincipal');
});


Route::get('/areas', function () {
    return view('areas');
});


Route::get('/atividadearea', function () {
    return view('atividadeArea');
});

Route::get('/problemaarea', function () {
    return view('problemaArea');
});

Route::get('/parametros', function () {
    return view('parametros');
});

Route::get('/usuarioatendimentoarea', function () {
    return view('usuarioAtendimentoArea');
});

Route::get('/chamados', function () {
    return view('chamados');
});
