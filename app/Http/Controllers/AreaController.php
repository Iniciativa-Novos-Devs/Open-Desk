<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        $areas = Area::select('id', 'nome', 'sigla')->paginate(20);


        return view('areas.index', [
            'areas' => $areas,
        ]);
    }

    public function show($area_id)
    {
        $area       = Area::with('atendentes')->find($area_id);

        if(!$area)
            return redirect()->route('dashboard')->with('error', 'Área não encontrada');

        $atendentes = Usuario::whereNotIn('id', $area->atendentes->pluck('id'))->select('id', 'name', 'email')->get();

        return view('areas.show', [
            'area'       => $area,
            'atendentes' => $atendentes,
        ]);
    }
}
