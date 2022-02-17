<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Route;

class PainelController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route('dashboard');
    }

    public static function routes()
    {
        Route::group(['prefix' => 'painel', 'middleware' => ['auth', 'redirect_to_base_host']], function () {
            //-----------------------------------------------------------------------------------
            DashboardController::routes();

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
        });
    }
}
