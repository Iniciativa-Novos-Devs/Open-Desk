<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\NovoChamadoMailJob;
use App\Models\Chamado;
use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Mail\NovoChamadoMail;
use App\Models\Anexo;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

class ChamadoController extends Controller
{
    public static function routes()
    {
        Route::get('/chamados', [ChamadoController::class, 'index'])->name('chamados_index');

        Route::get('/chamados/add', [ChamadoController::class, 'add'])
            ->middleware('permission:chamados-create|chamados-all')
            ->name('chamados_add');

        Route::post('/chamados/store', [ChamadoController::class, 'store'])->name('chamados_store');
        Route::get('/chamados/{chamado_id}/{chamado_slug?}', [ChamadoController::class, 'show'])->name('chamados_show');

        Route::get('/chamados/delete_atachment/{chamado_id}/{atachment_id}', [
            ChamadoController::class, 'deleteAtachment',
        ])->name('chamados_delete_atachment');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('chamados.index');
    }

    public function show($chamado_id)
    {
        $chamado = Chamado::with([
            'usuario', 'tipo_problema', 'problema',
            'logs' => function ($query) {
                $query->limit(25)
                    ->orderBy('created_at', 'desc')
                    ->with([
                        'usuario' => function ($query) {
                            $query->select('id', 'name');
                        },
                    ]);
            },
        ])->where('id', $chamado_id)->first();

        if (!$chamado) {
            return redirect()->route('chamados_index')->with('error', 'Chamado não encontrado');
        }

        return view('chamados.show', [
            'chamado' => $chamado,
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

        $user = auth()->user();

        $usuario = Usuario::where('email', $user->email)->first();

        if (!$usuario) { //TODO validar se o usuário tem a permissão de criar chamados
            return redirect()->route('chamados_index')->with('success', 'Usuario sem permissão para criar chamados');
        }

        $usuario_id = $usuario->id;

        if ($request->hasFile('anexos')) {
            $anexos = AnexoController::storeMultiFiles($request->file('anexos'), 'anexos', [
                'prefix_name' => 'chamado',
                'accepted_extensions' => ['pdf', 'png', 'jpg', 'jpeg', 'PDF', 'PNG', 'JPG', 'JPEG'],
                // 'restrito_a_grupos'     => [1,5,80],
                // 'restrito_a_usuarios'   => [5],
                // 'temporario'            => true,
                // 'destruir_apos'         => date('Y-m-d H:i:s', strtotime(' +1 days')),
                // 'created_by_id'         => 80,
            ]);
        }

        $request->validate([
            'problema_id' => 'required|numeric|exists:hd_problemas,id',
            'observacao' => 'required|min:10|max:500',
            'title' => 'required|min:5|max:100',
        ]);

        $novo_chamado = [
            'problema_id' => $request->input('problema_id'),
            'observacao' => htmlentities($request->input('observacao')),
            'title' => $request->input('title'),
        ];

        $novo_chamado['tipo_problema_id'] = null;
        $novo_chamado['usuario_id'] = $usuario_id;
        $novo_chamado['status'] = 1;            //TODO CRIAR CLASSE PARA ENUM  E APAGAR A TABELA STATUS
        $novo_chamado['versao'] = 1;            //TODO CRIAR CLASSE PARA ENUM  E APAGAR A TABELA STATUS
        $novo_chamado['anexos'] = $anexos ?? null;         //TODO No futuro aceitar varios anexos

        $chamado = Chamado::create($novo_chamado);

        if (!$chamado) {
            return redirect()->route('chamados_index')->with('error', 'O chamado não pode ser criado');
        }

        dispatch(new NovoChamadoMailJob($chamado));

        if ($request->input('create_another') == 'yes') {
            return redirect()->back()->with('success', 'Chamado criado com sucesso');
        }

        return redirect()->route('chamados_show', $chamado->id)->with('success', 'Chamado criado com sucesso');
    }

    public static function enviaEmailNovoChamado(Chamado $chamado)
    {
        if (!config('chamados.email.delivery_emails', true)) {
            return;
        }

        $email = $chamado->usuario->email ?? null;

        if ($email) {
            Mail::to($email)->send(new NovoChamadoMail($chamado));
        }
    }

    /**
     * function deleteAtachment.
     *
     * @param $chamado_id, $atachment_id
     *
     * @return
     */
    public function deleteAtachment($chamado_id, $atachment_id)
    {
        $chamado = Chamado::where('id', $chamado_id)->first();

        if (!$chamado) {
            return redirect()->route('chamados_show', $chamado_id)->with('error', 'Chamado não encontrado');
        }

        $atachment = $chamado->anexos->firstWhere('id', $atachment_id);

        if (!$atachment || !($atachment['id'] ?? null)) {
            return redirect()->route('chamados_show', $chamado_id)->with('error', 'Anexo inválido');
        }

        $anexo = Anexo::where('id', $atachment['id'])->first();

        if (!$anexo) {
            return redirect()->route('chamados_show', $chamado_id)->with('error', 'Anexo não encontrado');
        }

        if (file_exists(public_path($anexo->path))) {
            unlink(public_path($anexo->path));
        }

        $chamado->anexos = $chamado->anexos->where('id', '!=', $atachment_id);
        $chamado->save();

        $anexo->delete();

        return redirect()->route('chamados_show', $chamado_id)->with('success', 'Anexo deletado com sucesso');
    }
}
