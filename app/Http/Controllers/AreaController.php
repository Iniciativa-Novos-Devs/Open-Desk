<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Atividade;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        $area  = $request->input('area');

        $areas = Area::all();

        $atividades = Atividade::orderBy('id');

        if ($area && is_numeric($area))
            $atividades->where('area_id', (int) $area);


        return view('areas', [
            'areas' => $areas,
            'area_atual' => $area,
            'atividades' => $atividades->get(),
        ]);
    }
}
