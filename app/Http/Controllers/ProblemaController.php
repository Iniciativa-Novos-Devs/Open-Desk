<?php

namespace App\Http\Controllers;

use App\Models\Atividade;
use App\Models\Problema;
use Illuminate\Http\Request;

class ProblemaController extends Controller
{
    public function index()
    {
        return view('problemas.index');
    }

    public function add($atividade_id = null)
    {
        $atividades = Atividade::select('id', 'nome')->get();

        return view('problemas.add', [
            'atividades' => $atividades,
            'atividade_id' => $atividade_id,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'atividade_id'  => 'required|integer|exists:hd_atividades_area,id',
            'descricao'     => 'required|string|min:5',
        ]);

        Problema::create([
            'atividade_area_id' => $request->input('atividade_id'),
            'descricao'         => $request->input('descricao'),
        ]);

        return redirect()->route('problemas_index')->with('success', 'Problema criado com sucesso');
    }
}
