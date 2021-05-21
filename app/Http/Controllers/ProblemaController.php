<?php

namespace App\Http\Controllers;

use App\Models\Atividade;
use App\Models\Problema;
use Illuminate\Http\Request;

class ProblemaController extends Controller
{
    public function index($atividade_id = null)
    {
        return view('problemas.index', [
            'atividade_id' => $atividade_id,
        ]);
    }

    public function add($atividade_id)
    {
        $atividades = Atividade::select('id', 'nome')->get();

        return view('problemas.add', [
            'atividades'    => $atividades,
            'atividade_id'  => $atividade_id,
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

        return redirect()->route('problemas_index', $request->input('atividade_id'))->with('success', 'Problema criado com sucesso');
    }

    public function delete($problema_id)
    {
        $problema = Problema::where('id', $problema_id)->first();

        if(!$problema)
            return redirect()->route('problemas_index')->with('error', 'Problema não encontrado');

        $problema->delete();

        return redirect()->route('problemas_index')->with('success', 'Problema deletado com sucesso');
    }
}
