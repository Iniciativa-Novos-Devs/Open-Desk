<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AtividadesController;
use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\DashboardController;
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

Route::group(['prefix' => 'painel'], function () {    
    //-----------------------------------------------------------------------------------
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


    //-----------------------------------------------------------------------------------
    Route::get('/atividades', [AtividadesController::class, 'index'])->name('atividades_index');
    
    
    //-----------------------------------------------------------------------------------
    Route::get('/areas', [AreaController::class, 'index'])->name('areas_index');
    Route::get('/areas/{area_id}/{area_slug?}', [AreaController::class, 'show'])->name('areas_show');

    //-----------------------------------------------------------------------------------
    Route::get('/chamados', [ChamadoController::class, 'index'])->name('chamados_index');
    Route::get('/chamados/{chamado_id}/{chamado_slug?}', [ChamadoController::class, 'show'])->name('chamados_show');
    
});

