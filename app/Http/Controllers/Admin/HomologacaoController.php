<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ChamadoLogTypeEnum;
use App\Http\Controllers\Controller;
use App\Enums\StatusEnum;
use App\Models\Chamado;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Auth;
use URL;
use Illuminate\Support\Facades\Mail;

class HomologacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('homologarEmailUrl');
    }

    public static function routes()
    {
        Route::get('/homologacao',                                  [self::class, 'index'])->name('homologacao_index');
        Route::get('/homologacao/{chamado_id}',                     [self::class, 'show'])->name('homologacao_show');
        Route::get('/homologacao/{chamado_id}/{concluir}',          [self::class, 'homologar'])->name('homologacao_homologar');
        Route::post('/homologacao/{chamado_id}/update/{concluir}',  [self::class, 'update'])->name('homologacao_update');
    }

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
                        'atendente' => function($query) {
                            $query->select('id','name',);
                        },
                        'logs' => function ($query) {
                            $query->limit(25)
                                ->orderBy('created_at', 'desc')
                                ->with([
                                    'usuario' => function ($query) {
                                        $query->select('id','name',);
                                    },
                                ]);
                        },
                    ])
                    ->first();

        if(!$chamado)
            return redirect()->route('homologacao_index')->with('error', 'Chamado não encontrado ou inválido para homologação');

        return view('homologacao.show', [
            'chamado'   => $chamado,
            'user'      => $user,
        ]);
    }

    public function homologar(Request $request, $chamado_id, $concluir)
    {
        $concluir   = in_array($concluir, ['yes', 'no']) ? $concluir : null;

        if(!$concluir)
            return redirect()->route('homologacao_show', $chamado_id)
                    ->with('error', 'Favor escolha entre "homologar" e "não homologar"');

        $user       = Auth::user();

        if(!$user)
            return redirect()->route('homologacao_index')->with('error', 'Usuario não autenticado');

        $chamado = Chamado::where('usuario_id', $user->id)
                    ->whereIn('status', [StatusEnum::EM_HOMOLOGACAO, StatusEnum::HOMOLOGADO])
                    ->where('id', $chamado_id)
                    ->with([
                        'atendente' => function($query) {
                            $query->select('id','name',);
                        },
                        'logs' => function ($query) {
                            $query->limit(25)
                                ->orderBy('created_at', 'desc')
                                ->with([
                                    'usuario' => function ($query) {
                                        $query->select('id','name',);
                                    },
                                ]);
                        },
                    ])
                    ->first();

        if(!$chamado)
            return redirect()->route('homologacao_index')->with('error', 'Chamado não encontrado ou inválido para homologação');

        if($chamado->status == StatusEnum::HOMOLOGADO)
            return redirect()->route('homologacao_index')->with('error', "O chamado #{$chamado->id} já foi homologado");

        $view = ($concluir === 'yes') ? 'homologacao.rate' : 'homologacao.reopen';

        return view($view, [
            'chamado'  => $chamado,
            'user'     => $user,
            'concluir' => $concluir,
        ]);
    }

    public function update(Request $request, $chamado_id, $concluir)
    {
        $user = Auth::user();

        if(!$user)
            return redirect()->route('login')->with('error', 'Usuario não autenticado');

        $concluir   = in_array($concluir, ['yes', 'no']) ? $concluir : null;

        if(!$concluir)
            return redirect()->route('homologacao_show', $chamado_id)
                    ->with('error', 'Favor escolha entre "homologar" e "não homologar"');

        if($concluir === 'yes')
        {
            $validation = [
                'homologacao_nota'  => 'nullable|string|min:5',
                'rating'            => 'required|numeric',
            ];
        }else{
            $validation = [
                'homologacao_nota'  => 'required|string|min:5',
            ];
        }

        $request->validate($validation);

        $chamado = Chamado::where('usuario_id', $user->id)
                    ->where('status', StatusEnum::EM_HOMOLOGACAO)
                    ->where('id', $chamado_id)
                    ->with([
                        'atendente' => function($query) {
                            $query->select('id','name',);
                        },
                    ])
                    ->first();

        if(!$chamado)
            return redirect()->route('homologacao_show')->with('error', 'Chamado não encontrado ou inválido para homologação');

        $usuario_homologador = "{$user->id} - {$user->name}";

        if($concluir === 'yes')
        {
            $chamado->update([
                'homologacao_avaliacao'       => $request->input('rating'),
                'homologado_por'              => $user->id,
                'homologado_em'               => now(),
                'homologacao_observacao_back' => null,
                'homologacao_observacao_fim'  => htmlentities($request->input('homologacao_nota')),
                'status'                      => StatusEnum::HOMOLOGADO,
            ]);

            $chamado->logs()->create([
                'content' => htmlentities(($request->input('homologacao_nota') ?? "Homologado."). "\n<em>Usuário: {$usuario_homologador}</em>"),
                'type' => ChamadoLogTypeEnum::HOMOLOGADO,
            ]);

            return redirect()->route('homologacao_index')->with('success', "Chamado #{$chamado->id} homologado com sucesso");
        }else{
            $chamado->update([
                'homologacao_avaliacao'       => null,
                'homologado_por'              => null,
                'homologado_em'               => null,
                'homologacao_observacao_fim'  => null,
                'homologacao_observacao_back' => htmlentities($request->input('homologacao_nota')),
                'status'                      => StatusEnum::ABERTO,
            ]);

            $chamado->logs()->create([
                'content' => htmlentities(($request->input('homologacao_nota') ?? "Reaberto na homologação."). "\n<em>Usuário: {$usuario_homologador}</em>"),
                'type' => ChamadoLogTypeEnum::RETORNO_DA_HOMOLOGAÇÃO,
            ]);

            return redirect()->route('homologacao_index')->with('success', "Chamado #{$chamado->id} reaberto");
        }

        return redirect()->route('homologacao_index')->with('error', "Falha na homologação do chamado #{$chamado->id}");
    }

    public static function genHomologacaoPorEmail(int $chamado_id, int $expires_in_minutes = null)
    {
        $chamado = Chamado::with([
            'usuario' => function($query) {
                $query->select('id');
            },
        ])
        ->where('status', StatusEnum::EM_HOMOLOGACAO)
        ->where('id', $chamado_id)
        ->first();

        if (!$chamado || !$chamado->usuario)
            return null;

        $expires_in_minutes = $expires_in_minutes ?: config('sistema.signed_url.expires_in_minutes');

        if($expires_in_minutes && $expires_in_minutes > 0)
            return URL::temporarySignedRoute( 'homologacao_email_url', now()->addMinutes(30), [$chamado->id, $chamado->usuario->id]);

        return URL::signedRoute( 'homologacao_email_url', [$chamado->id, $chamado->usuario->id]);
    }

    public function homologarEmailUrl(Request $request, $chamado_id, $usuario_id)
    {
        $chamado = Chamado::with([
                'usuario' => function($query) {
                    $query->select('id','name',);
                },
        ])
        ->where('id', $chamado_id)
        ->where('usuario_id', $usuario_id)
        ->first();

        if (!$chamado)
            return redirect()->route('homologacao_index')->with('error', 'Chamado não encontrado ou inválido para homologação');

        $usuario = $chamado->usuario;

        if (!$usuario)
            abort(401);

        $auth = Auth::loginUsingId($usuario->id);

        if (!$auth)
            abort(401);

        return redirect()->route('homologacao_show', $chamado_id)->with('info', 'Login efetuado por URL assinada');
    }

    public static function sendHomologationRequestEmailToUser(Chamado $chamado)
    {
        if(!config('chamados.email.delivery_emails', true))
        {
            return;
        }

        $user = $chamado->usuario;

        if (!$user)
        {
            return false;
        }

        $title          = \Str::limit(strip_tags(html_entity_decode($chamado->title)), 20, '...');
        $chamado_url    = self::genHomologacaoPorEmail($chamado->id);

        if (!$chamado_url)
        {
            return null;
        }

        $email_data = [
            'email_subject'  =>  "Chamado #{$chamado->id}. - [Aguardando homologação] - {$title}",

            'email_intro'    =>    "<p>Olá {$user->name},</p>
                                    <p>Seu chamado foi fechado e aguarda sua homologação.</p>",

            'email_content'  =>  "<p>O chamado <strong>#{$chamado->id} - {$chamado->title} </strong> está em homologação.</p>",

            'email_footer' =>   '<p>Acesse o sistema para mais detalhes.</p>
                                <p>Atenciosamente,<br>Equipe de Suporte</p>',

            'call_to_actions' => [
                ['url' => $chamado_url, 'text' => 'Acessar chamado'],
            ],
        ];

        $email = $user->email ?? null;

        if($email)
            Mail::to('tiago@globo.com')
                ->send(new \App\Mail\GeneralProposalEmail($email_data));
    }

    public static function requestHomologationForAll()
    {
        Chamado::where('status', StatusEnum::EM_HOMOLOGACAO)
            ->where('finished_at', '<=', now()->subMinutes(60))
            ->chunk(50, function ($chamados) {
                foreach ($chamados as $chamado) {
                    self::sendHomologationRequestEmailToUser($chamado);
                }
            });
    }

}
