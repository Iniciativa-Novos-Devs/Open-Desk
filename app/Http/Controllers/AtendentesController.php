<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Atividade;
use App\Models\AreasUsuario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AtendentesController extends Controller
{
    public function index(Request $request)
    {
        $atendentes = Usuario::with('areas.atividades', 'roles')->paginate(20);

        return view('atendentes.index', [
            'atendentes'    => $atendentes,
        ]);
    }

    public function showAreasOfUsuario(Request $request, $usuario_id)
    {
        $atendente    = Usuario::where('id', $usuario_id)->with('areas', 'areas.atividades')->first();
        //Considerar...
        //Role::where('name', 'Atendente')->first()->usuario_roles->first()->usuarios()->limit(1)->get()

        if (!$atendente)
            return redirect()->route('dashboard')->with('error', 'Usuário não encontrado');

        $areas = Area::whereNotIn('id', $atendente->areas->pluck('id'))->select('id', 'nome', 'sigla')->get();

        return view('atendentes.areas_de_usuario', [
            'atendente' => $atendente,
            'areas'     => $areas,
        ]);
    }


    public function addAtividadeToUsuario(Request $request)
    {
        $request->validate([
            'area_id'       => 'required|exists:\App\Models\Area,id',
            'usuario_id'    => 'required|exists:\App\Models\Usuario,id',
        ]);

        $nova_atividade = [
            'usuario_id'    => $request->input('usuario_id'),
            'area_id'       => $request->input('area_id'),
        ];

        $status = AreasUsuario::updateOrCreate([
            'usuario_id'    => $nova_atividade['usuario_id'],
            'area_id'       => $nova_atividade['area_id'],
        ], $nova_atividade);

        if($status)
            $request->session()->flash('success', 'Atividade adiconada com sucesso');

        return redirect()->back();
    }

    public static function routes()
    {
        Route::prefix('atendentes')->group(function () {
            Route::get('/', [self::class, 'index'])->name('atendentes.index');
            Route::get('areas_por_usuario/{usuario_id}', [self::class, 'showAreasOfUsuario'])->name('atendentes.usuario.areas');
            Route::post('adicionar_atividade_ao_usuario', [self::class, 'addAtividadeToUsuario'])->name('atendentes.usuario.add_area');
        });
    }
}
