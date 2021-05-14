<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Atividade;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        $areas = Area::paginate(20);
        

        return view('areas.index', [
            'areas' => $areas,
        ]);
    }

    public function show($area_id)
    {
        $area = Area::find($area_id);

        if(!$area)
            return redirect()->route('dashboard')->with('error', 'Área não encontrada');

        return view('areas.show', [
            'area'      => $area,
        ]);
    }
}
