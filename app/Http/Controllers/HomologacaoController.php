<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\Chamado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Auth;

class HomologacaoController extends Controller
{
    public function index(Request $request)
    {
        return view('homologacao.index');
    }

    public function show($chamado_id = null)
    {
        $user = Auth::user();

        if(!$user)
            return redirect()->route('dashboard')->with('error', 'Usuario não autenticado');

        $chamado = Chamado::where('usuario_id', $user->id)
                    ->whereIn('status', [StatusEnum::EM_HOMOLOGACAO, StatusEnum::HOMOLOGADO])
                    ->where('id', $chamado_id)
                    ->with([
                        'homologadoPor' => function($query) {
                            $query->select('id','name',);
                        },
                    ])
                    ->first();

        if(!$chamado)
            return redirect()->route('dashboard')->with('error', 'Chamado não encontrado ou inválido para homologação');

        $historico  = [
            [
                'titulo' => 'Algo aqui 1',
                'usuario' => 'Fulano 1',
                'data'      => '2021-04-20 10:31:00',
                'conteudo'  => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aliquam amet impedit pariatur culpa possimus quidem fuga incidunt, cumque praesentium, dolorum totam repellendus quos in minima, magnam laudantium mollitia. Consequuntur, enim.',
            ],
            [
                'titulo' => 'Algo aqui 2',
                'usuario' => 'Fulano 2',
                'data'      => '2021-04-20 10:31:00',
                'conteudo'  => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aliquam amet impedit pariatur culpa possimus quidem fuga incidunt, cumque praesentium, dolorum totam repellendus quos in minima, magnam laudantium mollitia. Consequuntur, enim.',
            ],
            [
                'titulo' => 'Algo aqui 3',
                'usuario' => 'Fulano 3',
                'data'      => '2021-04-20 10:31:00',
                'conteudo'  => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aliquam amet impedit pariatur culpa possimus quidem fuga incidunt, cumque praesentium, dolorum totam repellendus quos in minima, magnam laudantium mollitia. Consequuntur, enim.',
            ],
            [
                'titulo' => 'Algo aqui 4',
                'usuario' => 'Fulano 4',
                'data'      => '2021-04-20 10:31:00',
                'conteudo'  => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aliquam amet impedit pariatur culpa possimus quidem fuga incidunt, cumque praesentium, dolorum totam repellendus quos in minima, magnam laudantium mollitia. Consequuntur, enim.',
            ],
            [
                'titulo' => 'Algo aqui 5',
                'usuario' => 'Fulano 5',
                'data'      => '2021-04-20 10:31:00',
                'conteudo'  => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aliquam amet impedit pariatur culpa possimus quidem fuga incidunt, cumque praesentium, dolorum totam repellendus quos in minima, magnam laudantium mollitia. Consequuntur, enim.',
            ],
        ];
        return view('homologacao.show', [
            'chamado'    => $chamado,
            'historico'  => $historico,
        ]);
    }

    public function update(Request $request, $id)
    {
        dd([__FILE__.':'.__LINE__]);
        $request->validate([
            'nome'      => 'required|min:3|max:50|string',
            'area_id'   => 'required|numeric|exists:hd_areas,id',
        ]);

        $atividade = Chamado::where('id', $id)->first();

        if(!$atividade)
            return redirect()->route('atividades_index')->with('error', 'Esta atividade não existe');

        $atividade->update([
            'nome' => $request->input('nome'),
            'area_id' => $request->input('area_id'),
        ]);

        return redirect()->route('atividades_index')->with('success', 'Chamado atualizada com sucesso');
    }

    public static function routes()
    {
        Route::get('/homologacao',                          [self::class, 'index'])->name('homologacao_index');
        Route::get('/homologacao/{chamado_id}',             [self::class, 'show'])->name('homologacao_show');
        Route::post('/homologacao/{chamado_id}/update',     [self::class, 'update'])->name('homologacao_update');
    }

}
