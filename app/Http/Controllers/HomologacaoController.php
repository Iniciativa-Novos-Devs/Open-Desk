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

    public function show(Request $request, $chamado_id)
    {
        $user = Auth::user();

        if(!$user)
            return redirect()->route('homologacao_index')->with('error', 'Usuario não autenticado');

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
            return redirect()->route('homologacao_index')->with('error', 'Chamado não encontrado ou inválido para homologação');

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
            'chamado'   => $chamado,
            'user'      => $user,
            'historico' => $historico,
        ]);
    }

    public function homologar(Request $request, $chamado_id, $concluir)
    {
        $concluir   = in_array($concluir, ['yes', 'no']) ? $concluir : null;

        if(!$concluir)
            return redirect()->route('homologacao_show', $chamado_id)
                    ->with('error', 'Favor escolha entre "homologar" e "não homologar"');

        $concluir   = $concluir === 'yes';

        $user       = Auth::user();

        if(!$user)
            return redirect()->route('homologacao_index')->with('error', 'Usuario não autenticado');

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
            return redirect()->route('homologacao_index')->with('error', 'Chamado não encontrado ou inválido para homologação');

        if($chamado->status == StatusEnum::HOMOLOGADO)
            return redirect()->route('homologacao_index')->with('error', "O chamado #{$chamado->id} já foi homologado");

        $view = $concluir ? 'homologacao.rate' : 'homologacao.reopen';

        return view($view, [
            'chamado'  => $chamado,
            'user'     => $user,
            'concluir' => $concluir,
        ]);
    }

    public function update(Request $request, $chamado_id)
    {
        $user = Auth::user();

        if(!$user)
            return redirect()->route('login')->with('error', 'Usuario não autenticado');

        $request->validate([
            'rating'            => 'required|numeric',
            'homologacao_nota'  => 'nullable|string|min:5',
        ]);

        $chamado = Chamado::where('usuario_id', $user->id)
                    ->where('status', StatusEnum::EM_HOMOLOGACAO)
                    ->where('id', $chamado_id)
                    ->with([
                        'homologadoPor' => function($query) {
                            $query->select('id','name',);
                        },
                    ])
                    ->first();

        if(!$chamado)
            return redirect()->route('homologacao_show')->with('error', 'Chamado não encontrado ou inválido para homologação');

        $chamado->update([
            'homologacao_avaliacao'      => $request->input('rating'),
            'homologado_por'             => $user->id,
            'homologado_em'              => now(),
            'homologacao_observacao_fim' => htmlentities($request->input('homologacao_nota')),
            'status'                     => StatusEnum::HOMOLOGADO,
        ]);

        return redirect()->route('homologacao_index')->with('success', "Chamado #{$chamado->id} homologado com sucesso");
    }

    public static function routes()
    {
        Route::get('/homologacao',                          [self::class, 'index'])->name('homologacao_index');
        Route::get('/homologacao/{chamado_id}',             [self::class, 'show'])->name('homologacao_show');
        Route::get('/homologacao/{chamado_id}/{concluir}',  [self::class, 'homologar'])->name('homologacao_homologar');
        Route::post('/homologacao/{chamado_id}/update',     [self::class, 'update'])->name('homologacao_update');
    }

}
