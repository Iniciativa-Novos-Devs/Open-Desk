<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class UsuarioController extends Controller
{
    public static function routes()
    {
        Route::prefix('usuarios')->group(function () {
            Route::get('/', [self::class, 'index'])->name('usuarios.index');
            Route::get('/show/{usuarios_id}', [self::class, 'show'])->name('usuarios.show');
            Route::get('/edit/{usuarios_id}', [self::class, 'edit'])->name('usuarios.edit');
            Route::get('/delete/{usuarios_id}', [self::class, 'destroy'])->name('usuarios.delete');
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $actions = [
            'view' => [
                'label' => __('Show'),
                'icon' => 'bi-eye-fill',
                'class' => 'btn-primary',
                'route' => 'usuarios.show',
                'route_params' => ['id' => 'id'],
            ],
            'edit' => [
                'label' => __('Edit'),
                'icon' => 'bi-pencil-fill',
                'class' => 'btn-info',
                'route' => 'usuarios.edit',
                'route_params' => ['id' => 'id'],
            ],
        ];

        return view('admin.usuarios.index', [
            'usuarios'  => Usuario::paginate(10),
            'columns'   => [
                'id' => 'ID',
                'name' => 'Nome',
            ],
            'actions'   => $actions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario)
        {
            return redirect()->route('usuarios.index')->with('error', __('User not found'));
        }

        return view('admin.usuarios.show', [
            'usuario' => $usuario,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario)
        {
            return redirect()->route('usuarios.index')->with('error', __('User not found'));
        }

        return view('admin.usuarios.form', [
            'usuario' => $usuario,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario)
        {
            return redirect()->route('usuarios.index')->with('error', __('User not found'));
        }

        if($usuario->hasAnyRole(['admin', 'super-admin']))
            return redirect()->route('usuarios.index')->with('error', __('Admin user can not be deleted'));

        if (\Auth::user()->id != $usuario->id)
            return redirect()->route('usuarios.index')->with('error', __('The logged user can not be deleted'));

        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', __('User deleted successfully'));
    }
}
