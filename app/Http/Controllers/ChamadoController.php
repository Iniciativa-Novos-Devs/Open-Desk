<?php

namespace App\Http\Controllers;

use App\Models\Chamado;
use App\Models\Problema;
use Illuminate\Http\Request;

class ChamadoController extends Controller
{
    public function index(Request $request)
    {
        # code...
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
        $request->validate([
            'tipo_problema_id'  => 'required|numeric|exists:hd_tipo_problemas,id',
            'area_id'           => 'required|numeric|exists:hd_areas,id',
            'problema_id'       => 'required|numeric|exists:hd_problemas,id',
            'usuario_id'        => 'required|numeric|exists:hd_usuarios,id',
            'imagem_id'         => 'nullable|numeric|exists:hd_imagens,id',
            'observacao'        => 'required|min:10|max:500',
            'versao'            => 'required|string|min:10',
        ]);

        Chamado::create([
            'tipo_problema_id'  => $request->input('tipo_problema_id'),
            'area_id'           => $request->input('area_id'),
            'problema_id'       => $request->input('problema_id'),
            'usuario_id'        => $request->input('usuario_id'),
            'imagem_id'         => $request->input('imagem_id'),
            'observacao'        => $request->input('observacao'),
            'versao'            => $request->input('versao'),
            'status_id'         => 1, //TODO CRIAR CLASSE PARA ENUM  E APAGAR A TABELA STATUS
        ]);

        return redirect()->route('atividades_index')->with('success', 'Atividade criada com sucesso');
    }

}
