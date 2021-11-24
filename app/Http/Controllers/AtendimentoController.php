<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AtendimentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:atendente');
    }

    public static function routes()
    {
        Route::get('/atendimentos', [self::class, 'index'])->name('atendimentos_index');
    }

    public function index(Request $request)
    {
        return view('atendimentos.index');
    }
}
