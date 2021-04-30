<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProblemaController extends Controller
{
    public function index()
    {
        return view ('problemas.index');
    }
}
