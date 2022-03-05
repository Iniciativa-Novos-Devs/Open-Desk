<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class UnidadeController extends Controller
{
    public static function routes()
    {
        Route::resource('unidades', self::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('unidades.index', [
            'unidades' => Unidade::paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('unidades.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "ue" => "required|string|min:3|max:3|unique:hd_unidades,ue",
            "nome" => "required|string|min:10|max:150",
            "cidade" => "nullable|string|min:3|max:100",
        ]);

        $unidade = Unidade::create([
            "ue" => $request->input('ue'),
            "nome" => $request->input('nome'),
            "cidade" => $request->input('cidade'),
            "diretor" => $request->input('diretor'),
            "dir_adm" => $request->input('dir_adm'),
        ]);

        if (!$unidade) {
            return back()->with('error', 'Falha no cadastro da unidade');
        }

        return redirect()->route('unidades.index')->with("success", "Unidade cadastrada com sucesso");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unidade = Unidade::where('id', $id)->first();

        if (!$unidade) {
            return redirect()->route('unidades.index')->with('error', 'Unidade não encontrada');
        }

        return view('unidades.form', [
            'unidade' => $unidade,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $unidade = Unidade::where('id', $id)->first();

        if (!$unidade) {
            return redirect()->route('unidades.index')->with('error', 'Unidade não encontrada');
        }

        $request->validate([
            "nome" => "required|string|min:10|max:150",
            "cidade" => "nullable|string|min:3|max:100",
        ]);

        $updaded = $unidade->update([
            "nome" => $request->input('nome'),
            "cidade" => $request->input('cidade'),
            "diretor" => $request->input('diretor'),
            "dir_adm" => $request->input('dir_adm'),
        ]);

        if (!$updaded) {
            return back()->with('error', 'Falha ao atualizar unidade')->withInput();
        }

        return redirect()->route('unidades.index')->with("success", "Unidade atualizada com sucesso");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
