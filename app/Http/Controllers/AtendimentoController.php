<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AtendimentoController extends Controller
{
    public function index(Request $request)
    {
        return view('atendimento.index');
    }

    public static function routes()
    {
        Route::get('/atendimentos', [ChamadoController::class, 'index'])->name('atendimentos_index');
    }
}
