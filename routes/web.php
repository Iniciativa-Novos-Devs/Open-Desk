<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AtividadesController;
use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PainelController;
use App\Http\Controllers\ProblemaController;
use App\Http\Controllers\RoleManagerController;
use App\Http\Controllers\AtendentesController;
use App\Http\Controllers\AtendimentoController;
use App\Http\Controllers\UserPreferencesController;
use App\Http\Controllers\ValidadorCpsUsuarioController;
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

Route::group(['prefix' => 'painel', 'middleware' => ['auth', 'redirect_to_base_host']], function () {
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

    ChamadoController::routes();
    //-----------------------------------------------------------------------------------
    ProblemaController::routes();
    //-----------------------------------------------------------------------------------
    RoleManagerController::routes();
    //-----------------------------------------------------------------------------------
    AtendentesController::routes();
    //-----------------------------------------------------------------------------------
    AtendimentoController::routes();
    //-----------------------------------------------------------------------------------
    UserPreferencesController::routes();
    //-----------------------------------------------------------------------------------
});

Route::get('teste', function(){
    return Auth::user()->name;
})->middleware(['auth']);

Route::group(['middleware' => ['redirect_to_base_host']], function () {
    require __DIR__.'/auth.php';
});

Route::group(['prefix' => 'alpine', 'middleware' => ['redirect_to_base_host']], function () {

    Route::get('select', function() {
        return view('alpine.select');
    })->name('alpine.select');

    Route::get('select_async', function() {
        return view('alpine.select_async');
    })->name('alpine.select_async');

    Route::get('api/text', function () {
        return response()->json("Texto vindo da api ". rand(100, 300));
    })->name('alpine.api_text');

    Route::get('api/pessoas', function () {
        return [
            ['id' => 1,'nome' => 'Tiago'],
            ['id' => 2,'nome' => 'Joao'],
            ['id' => 3,'nome' => 'Pedro'],
            ['id' => 4,'nome' => 'Paulo'],
        ];
    })->name('alpine.api_pessoas');
});

Route::get('fake-cps', [ValidadorCpsUsuarioController::class, 'fakeCpsResponse'])->name('fake_url_valida_usuario_cps');
Route::get('valida-cps', [ValidadorCpsUsuarioController::class, 'secondLogin'])->middleware('auth')->name('valida_usuario_cps');
Route::post('valida-cps', [ValidadorCpsUsuarioController::class, 'validateCpsUser'])->middleware('auth');
