<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AtividadesController;
use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PainelController;
use App\Http\Controllers\ProblemaController;
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

Route::get('/', [DashboardController::class , 'index']);
Route::get('/dashboard', [DashboardController::class , 'index'])->name('dashboard');

Route::group(['prefix' => 'painel', 'middleware' => ['auth']], function () {
    //-----------------------------------------------------------------------------------
    Route::get('/', [PainelController::class, 'index'])->name('painel');


    //-----------------------------------------------------------------------------------
    Route::get('/atividades', [AtividadesController::class, 'index'])->name('atividades_index');
    Route::get('/atividades/{id}/edit', [AtividadesController::class, 'edit'])->name('atividades_edit');
    Route::post('/atividades/{id}/update', [AtividadesController::class, 'update'])->name('atividades_update');
    Route::get('/atividades/add/{area_id?}', [AtividadesController::class, 'add'])->name('atividades_add');
    Route::post('/atividades/store', [AtividadesController::class, 'store'])->name('atividades_store');
    Route::get('/atividades/{id}/delete', [AtividadesController::class, 'delete'])->name('atividades_delete');


    //-----------------------------------------------------------------------------------
    Route::get('/areas', [AreaController::class, 'index'])->name('areas_index');
    Route::get('/areas/{area_id}/{area_slug?}', [AreaController::class, 'show'])->name('areas_show');


    //-----------------------------------------------------------------------------------
    Route::get('/chamados', [ChamadoController::class, 'index'])->name('chamados_index');
    Route::get('/chamados/add', [ChamadoController::class, 'add'])->name('chamados_add');
    Route::post('/chamados/store', [ChamadoController::class, 'store'])->name('chamados_store');
    Route::get('/chamados/{chamado_id}/{chamado_slug?}', [ChamadoController::class, 'show'])->name('chamados_show');


    //-----------------------------------------------------------------------------------
    Route::get('/problemas/{atividade_id?}', [ProblemaController::class, 'index'])->name('problemas_index');
    Route::get('/problemas/add/atividade/{atividade_id}', [ProblemaController::class, 'add'])->name('problemas_add');
    Route::get('/problemas/edit/{atividade_id}', [ProblemaController::class, 'edit'])->name('problemas_edit');
    Route::get('/problemas/delete/{atividade_id}', [ProblemaController::class, 'delete'])->name('problemas_delete');
    Route::post('/problemas/store', [ProblemaController::class, 'store'])->name('problemas_store');

});

Route::get('teste', function(){
    return Auth::user()->name;
})->middleware(['auth']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
