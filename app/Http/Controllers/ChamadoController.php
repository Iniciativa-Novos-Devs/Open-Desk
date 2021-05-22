<?php

namespace App\Http\Controllers;

use App\Models\Chamado;
use App\Models\Usuario;
use Illuminate\Http\Request;

class ChamadoController extends Controller
{
    public function index(Request $request)
    {
        return 'aqui é "chamados_index" '
        .'<a href="'. route('chamados_add') .'">Adicionar chamado</a>';
    }

    public function show($chamado_id)
    {
        $chamado    = [
            'titulo'   => 'Chamado '. $chamado_id,
            'usuario'  => 'Fulano',
            'conteudo' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Provident magni illum doloribus ut obcaecati tenetur. Rerum maiores quo non quidem nisi blanditiis sed cupiditate, minus quisquam eaque provident cumque a?',
        ];

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
        /**
         //TODO fazer validação de usuários aqui
         //permitir que um chamado seja criado por um atendente enviando um udentificador desse usuário

         $user       = auth()->user();

         if(!$user)
             return redirect()->route('chamados_index')->with('success', 'Apenas usuario sem permissão para criar chamados');

         $usuario = Usuario::where('email', $user->email)->first();

         if(!$usuario)
             return redirect()->route('chamados_index')->with('success', 'Apenas usuario sem permissão para criar chamados');

         $usuario_id = $usuario->id;
         */

        $usuario_id = 1; //TODO fazer validação de usuários aqui

        $request->validate([
            'problema_id'       => 'required|numeric|exists:hd_problemas,id',
            'observacao'        => 'required|min:10|max:500',
        ]);

        $novo_chamado = [
            'problema_id'       => $request->input('problema_id'),
            'observacao'        => $request->input('observacao'),
        ];

        $novo_chamado['tipo_problema_id'] = null;
        $novo_chamado['usuario_id']       = $usuario_id;
        $novo_chamado['status']           = 1;            //TODO CRIAR CLASSE PARA ENUM  E APAGAR A TABELA STATUS
        $novo_chamado['versao']           = 1;            //TODO CRIAR CLASSE PARA ENUM  E APAGAR A TABELA STATUS
        $novo_chamado['anexos']           = null;         //TODO No futuro aceitar varios anexos

        Chamado::create($novo_chamado);

        return redirect()->route('chamados_index')->with('success', 'Chamado criado com sucesso');
    }

}
