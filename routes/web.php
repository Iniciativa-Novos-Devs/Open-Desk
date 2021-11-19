<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AreaController;
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
use App\Http\Controllers\HomologacaoController;

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
    \App\Http\Controllers\AtividadesController::routes();

    //-----------------------------------------------------------------------------------
    HomologacaoController::routes();


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

    Route::get('/', function(){
        return redirect()->route('alpine.select');
    });

    Route::get('select', function() {
        return view('alpine.select');
    })->name('alpine.select');

    Route::get('select_async', function() {
        return view('alpine.select_async');
    })->name('alpine.select_async');

    Route::get('api/text', function () {
        return response()->json("Texto vindo da api ". rand(100, 300));
    })->name('alpine.api_text');

    Route::get('api/pessoas/{optional_value?}', function ($optional_value = null) {
        return [
            ['id' => 1,'nome' => 'Tiago'],
            ['id' => 2,'nome' => 'Joao'],
            ['id' => 3,'nome' => 'Pedro'],
            ['id' => 4,'nome' => 'Paulo'],
            ['id' => 5,'nome' => $optional_value ?? "Inicial"],
        ];
    })->name('alpine.api_pessoas');
});

Route::get('fake-cps', [ValidadorCpsUsuarioController::class, 'fakeCpsResponse'])->name('fake_url_valida_usuario_cps');
Route::get('valida-cps', [ValidadorCpsUsuarioController::class, 'secondLogin'])->middleware('auth')->name('valida_usuario_cps');
Route::post('valida-cps', [ValidadorCpsUsuarioController::class, 'validateCpsUser'])->middleware('auth');

Route::prefix('signed_url')->middleware(['signed_url'])->group(function () {

    Route::get('/homologacao/{chamado_id}/mac{usuario_id}/email_url', [HomologacaoController::class, 'homologarEmailUrl'])->name('homologacao_email_url');

});

Route::get('/register', function(){
    return redirect()->route('login')->with('error', 'Acesso não autorizado!');
});
