<?php

namespace App\Http\Controllers;

use App\Models\Atividade;
use App\Models\AtividadeAreasUsuario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class UsuarioManagerController extends Controller
{
    public function showAtividadesOfUsuario(Request $request, $usuario_id)
    {
        $atividades = Atividade::select('id', 'nome')->get();
        $usuario    = Usuario::where('id', $usuario_id)->with('atividades.area')->first();

        if (!$usuario)
            return redirect()->route('dashboard')->with('error', 'Usuário não encontrado');

        return view('usuarios.atividades_de_usuario', [
            'usuario'    => $usuario,
            'atividades' => $atividades,
        ]);
    }


    public function addAtividadeToUsuario(Request $request, $usuario_id)
    {
        $request['usuario_id'] = $usuario_id ?? $request->input('usuario_id');

        $request->validate([
            'atividades_area_id' => 'required|exists:\App\Models\Atividade,id',
            'usuario_id'         => 'required|exists:\App\Models\Usuario,id',
        ]);

        $nova_atividade = [
            'usuario_id'         => $request->input('usuario_id'),
            'atividades_area_id' => $request->input('atividades_area_id'),
        ];

        $status = AtividadeAreasUsuario::updateOrCreate([
            'usuario_id'         => $nova_atividade['usuario_id'],
            'atividades_area_id' => $nova_atividade['atividades_area_id'],
        ], $nova_atividade);

        if($status)
            $request->session()->flash('success', 'Atividade adiconada com sucesso');

        return redirect()->back();
    }

    public static function routes()
    {
        Route::prefix('usuarios')->group(function () {
            Route::get('atividades_por_usuario/{usuario_id}', [self::class, 'showAtividadesOfUsuario'])->name('atividades_por_usuario');
            Route::post('adicionar_atividade_ao_usuario/{usuario_id}', [self::class, 'addAtividadeToUsuario'])->name('add_atividade_ao_usuario');
        });
    }
}
