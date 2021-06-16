<?php

namespace App\Http\Controllers;

use App\Models\UsuarioRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RoleManagerController extends Controller
{
    public function addRolesToUsuario(Request $request)
    {
        $request->validate([
            'roles' => 'required|array',
            'usuario_id' => 'required|exists:\App\Models\Usuario,id',
        ]);

        foreach ($request->roles as $role)
        {
            $new_user_role = [
                'usuario_id' => $request->input('usuario_id'),
                'role_uid'   => $role,
            ];

            dd($new_user_role);//TODO testar e remover

            UsuarioRole::updateOrCreate([
                'usuario_id' => $new_user_role['usuario_id'],
                'role_uid'   => $new_user_role['role_uid'],
            ], $new_user_role);
        }
    }

    public static function routes()
    {
        Route::post('roles/add_roles_to_usuario', [self::class, 'addRolesToUsuario'])->name('role_manager_add_roles_to_usuario');
    }
}
