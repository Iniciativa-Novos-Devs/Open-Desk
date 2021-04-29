<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Atividade;
use Illuminate\Http\Request;

class AtividadesController extends Controller
{
    public function index(Request $request)
    {
        return view('atividades.index');
    }

    public function edit($id)
    {
        $atividade = Atividade::where('id', $id)->first();

        if(!$atividade)
            return redirect()->route('atividades_index')->with('error', 'Esta atividade não existe');

        return view('atividades.form', [
            'atividade' => $atividade,
            'id'        => $id,
        ]);
    }

    public function add()
    {
        return view('atividades.form');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|min:3|max:50|string',
        ]);

        $atividade = Atividade::where('id', $id)->first();

        if(!$atividade)
            return redirect()->route('atividades_index')->with('error', 'Esta atividade não existe');

        $atividade->update([
            'nome' => $request->input('nome'),
        ]);

        return redirect()->route('atividades_index')->with('success', 'Atividade atualizada com sucesso');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|min:3|max:50|string',
        ]);

        Atividade::create([
            'nome' => $request->input('nome'),
        ]);

        return redirect()->route('atividades_index')->with('success', 'Atividade criada com sucesso');
    }



}
