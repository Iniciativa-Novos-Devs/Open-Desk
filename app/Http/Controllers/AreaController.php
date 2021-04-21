<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Atividade;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        return view('areas');
    }
}
