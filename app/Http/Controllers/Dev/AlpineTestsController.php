<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Route;

class AlpineTestsController extends Controller
{
    public static function routes()
    {

        Route::group(['prefix' => 'alpine', 'middleware' => ['redirect_to_base_host']], function ()
        {

            Route::get('/', function ()
            {
                return redirect()->route('alpine.select');
            });

            Route::get('select', function ()
            {
                return view('alpine.select');
            })->name('alpine.select');

            Route::get('select_async', function ()
            {
                return view('alpine.select_async');
            })->name('alpine.select_async');

            Route::get('api/text', function ()
            {
                return response()->json("Texto vindo da api " . rand(100, 300));
            })->name('alpine.api_text');

            Route::get('api/pessoas/{optional_value?}', function ($optional_value = null)
            {
                return [
                    ['id' => 1, 'nome' => 'Tiago'],
                    ['id' => 2, 'nome' => 'Joao'],
                    ['id' => 3, 'nome' => 'Pedro'],
                    ['id' => 4, 'nome' => 'Paulo'],
                    ['id' => 5, 'nome' => $optional_value ?? "Inicial"],
                ];
            })->name('alpine.api_pessoas');
        });
    }
}
