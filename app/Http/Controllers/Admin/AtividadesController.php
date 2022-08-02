<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Atividade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AtividadesController extends Controller
{
    public function index(Request $request)
    {
        return view('atividades.index');
    }

    public function edit($id)
    {
        $atividade = Atividade::where('id', $id)->first();

        if (! $atividade) {
            return redirect()->route('atividades_index')->with('error', 'Esta atividade não existe');
        }

        return view('atividades.form', [
            'atividade' => $atividade,
            'id' => $id,
        ]);
    }

    public function add($area_id = null)
    {
        return view('atividades.form', [
            'area_id' => $area_id,
            'areas' => Area::select('id', 'sigla', 'nome')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|min:3|max:50|string',
            'area_id' => 'required|numeric|exists:hd_areas,id',
        ]);

        $atividade = Atividade::where('id', $id)->first();

        if (! $atividade) {
            return redirect()->route('atividades_index')->with('error', 'Esta atividade não existe');
        }

        $atividade->update([
            'nome' => $request->input('nome'),
            'area_id' => $request->input('area_id'),
        ]);

        return redirect()->route('atividades_index')->with('success', 'Atividade atualizada com sucesso');
    }

    public function delete(Request $request, $id)
    {
        $atividade = Atividade::where('id', $id)->first();

        if (! $atividade) {
            return redirect()->route('atividades_index')->with('error', 'Esta atividade não existe');
        }

        $atividade->delete();

        return redirect()->route('atividades_index')->with('success', 'Atividade deletada com sucesso');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|min:3|max:50|string',
            'area_id' => 'required|numeric|exists:hd_areas,id',
        ]);

        Atividade::create([
            'nome' => $request->input('nome'),
            'area_id' => $request->input('area_id'),
        ]);

        return redirect()->route('atividades_index')->with('success', 'Atividade criada com sucesso');
    }

    public static function routes()
    {
        Route::get('/atividades', [AtividadesController::class, 'index'])->name('atividades_index');
        Route::get('/atividades/{id}/edit', [AtividadesController::class, 'edit'])->name('atividades_edit');
        Route::post('/atividades/{id}/update', [AtividadesController::class, 'update'])->name('atividades_update');
        Route::get('/atividades/add/{area_id?}', [AtividadesController::class, 'add'])->name('atividades_add');
        Route::post('/atividades/store', [AtividadesController::class, 'store'])->name('atividades_store');
        Route::get('/atividades/{id}/delete', [AtividadesController::class, 'delete'])->name('atividades_delete');
    }
}
