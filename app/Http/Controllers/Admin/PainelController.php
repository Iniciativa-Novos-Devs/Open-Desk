<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
            RoleController::routes();
            //-----------------------------------------------------------------------------------
            AtendentesController::routes();
            //-----------------------------------------------------------------------------------
            AtendimentoController::routes();
            //-----------------------------------------------------------------------------------
            UserPreferencesController::routes();
            //-----------------------------------------------------------------------------------
            UsuarioController::routes();
            //-----------------------------------------------------------------------------------
            UserMassiveImportController::routes();
            //-----------------------------------------------------------------------------------
        });
    }

    public function index(Request $request)
    {
        return view('dashboard.index');
    }
}
