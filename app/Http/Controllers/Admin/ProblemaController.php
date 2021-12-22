<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atividade;
use App\Models\Problema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ProblemaController extends Controller
{
    public static function routes()
    {
        Route::get('/problemas/{atividade_id?}', [ProblemaController::class, 'index'])->name('problemas_index');
        Route::get('/problemas/add/atividade/{atividade_id}', [ProblemaController::class, 'add'])->name('problemas_add');
        Route::get('/problemas/edit/{atividade_id}', [ProblemaController::class, 'edit'])->name('problemas_edit');
        Route::get('/problemas/delete/{atividade_id}', [ProblemaController::class, 'delete'])->name('problemas_delete');
        Route::post('/problemas/store', [ProblemaController::class, 'store'])->name('problemas_store');
    }

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
