<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\ProblemaController;
use App\Http\Controllers\RoleManagerController;
use App\Http\Controllers\AtendentesController;
use App\Http\Controllers\AtendimentoController;
use App\Http\Controllers\AtividadesController;
use App\Http\Controllers\UserPreferencesController;
use App\Http\Controllers\HomologacaoController;
use Illuminate\Http\Request;
use Route;

class PainelController extends Controller
{
    public static function routes()
    {
        Route::group(['prefix' => 'painel', 'middleware' => ['auth', 'redirect_to_base_host']], function () {
            //-----------------------------------------------------------------------------------
            Route::get('/', [self::class, 'index'])->name('painel');

            //-----------------------------------------------------------------------------------
            AtividadesController::routes();
            //-----------------------------------------------------------------------------------
            HomologacaoController::routes();
            //-----------------------------------------------------------------------------------
            AreaController::routes();
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
            UsuarioController::routes();
            //-----------------------------------------------------------------------------------
        });
    }

    public function index(Request $request)
    {
        return view('dashboard.index');
    }
}
