<?php

namespace App\Http\Controllers;

use App\Jobs\NovoChamadoMailJob;
use App\Models\Chamado;
use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Mail\NovoChamadoMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

class ChamadoController extends Controller
{
    public function index(Request $request)
    {
        return view('chamados.index');
    }

    public function show($chamado_id)
    {
        $chamado    = Chamado::with('usuario', 'tipo_problema', 'problema')->where('id', $chamado_id)->first();
        //TODO criar relação "histórico"

        if(!$chamado)
            return redirect()->route('chamados_index')->with('error', 'Chamado não encontrado');

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

        return view('chamados.show', [
            'chamado'   => $chamado,
            'historico' => $historico,
        ]);
    }

    public function add(Request $request)
    {
        return view('chamados.form');
    }

    public function store(Request $request)
    {
        //TODO fazer validação de usuários aqui
        //permitir que um chamado seja criado por um atendente enviando um udentificador desse usuário

        $user       = auth()->user();

        if(!$user)
            return redirect()->route('chamados_index')->with('success', 'Acesso não autorizado');

        $usuario = Usuario::where('email', $user->email)->first();

        if(!$usuario)//TODO validar se o usuário tem a permissão de criar chamados
            return redirect()->route('chamados_index')->with('success', 'Usuario sem permissão para criar chamados');

        $usuario_id = $usuario->id;

        if ($request->hasFile('anexos'))
            $anexos = AnexoController::storeMultiFiles($request->file('anexos'), 'anexos', [
                'prefix_name'           => 'chamado',
                'accepted_extensions'   => ['pdf', 'png', 'jpg', 'jpeg', 'PDF', 'PNG', 'JPG', 'JPEG'],
                // 'restrito_a_grupos'     => [1,5,80],
                // 'restrito_a_usuarios'   => [5],
                // 'temporario'            => true,
                // 'destruir_apos'         => date('Y-m-d H:i:s', strtotime(' +1 days')),
                // 'created_by_id'         => 80,
            ]);

        $request->validate([
            'problema_id'       => 'required|numeric|exists:hd_problemas,id',
            'observacao'        => 'required|min:10|max:500',
            'title'             => 'required|min:5|max:100',
        ]);

        $novo_chamado = [
            'problema_id'       => $request->input('problema_id'),
            'observacao'        => htmlentities($request->input('observacao')),
            'title'             => $request->input('title'),
        ];

        $novo_chamado['tipo_problema_id'] = null;
        $novo_chamado['usuario_id']       = $usuario_id;
        $novo_chamado['status']           = 1;            //TODO CRIAR CLASSE PARA ENUM  E APAGAR A TABELA STATUS
        $novo_chamado['versao']           = 1;            //TODO CRIAR CLASSE PARA ENUM  E APAGAR A TABELA STATUS
        $novo_chamado['anexos']           = $anexos ?? null;         //TODO No futuro aceitar varios anexos

        $chamado = Chamado::create($novo_chamado);

        if(!$chamado)
            return redirect()->route('chamados_index')->with('error', 'O chamado não pode ser criado');

        dispatch(new NovoChamadoMailJob($chamado));

        if($request->input('create_another') == 'yes')
            return redirect()->back()->with('success', 'Chamado criado com sucesso');

        return redirect()->route('chamados_index')->with('success', 'Chamado criado com sucesso');
    }

    public static function enviaEmailNovoChamado(Chamado $chamado)
    {
        $email = $chamado->usuario->email ?? null;

        if($email)
            Mail::to($email)->send(new NovoChamadoMail($chamado));
    }

    public static function routes()
    {
        Route::get('/chamados', [ChamadoController::class, 'index'])->name('chamados_index');
        Route::get('/chamados/add', [ChamadoController::class, 'add'])->name('chamados_add');
        Route::post('/chamados/store', [ChamadoController::class, 'store'])->name('chamados_store');
        Route::get('/chamados/{chamado_id}/{chamado_slug?}', [ChamadoController::class, 'show'])->name('chamados_show');
    }

}
