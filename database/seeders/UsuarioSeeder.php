<?php

namespace Database\Seeders;

use App\Models\Unidade;
use App\Models\Usuario;
use Arr;
use Illuminate\Database\Seeder;
use Permission;
use Role;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unidades = Unidade::select('ue')->limit(30)->get();

        if (! $unidades) {
            return;
        }

        $unidades_array = $unidades->toArray();

        if ($unidades_array) {
            $usuarios = [
                [
                    'name' => 'Admin',
                    'email' => 'adm@adm.com',
                    'password' => bcrypt('123'),
                    'email_verified_at' => now(),
                    'telefone_1' => '41 9888888',
                    'telefone_1_wa' => true,
                    'versao' => 1,
                    'roles' => ['admin', 'super-admin', 'atendente'],
                    'permissions' => [],
                    'app_admin' => true,
                ],
                [
                    'name' => 'Admin 2',
                    'email' => 'admin@mail.com',
                    'password' => bcrypt('power@123'),
                    'email_verified_at' => now(),
                    'telefone_1' => '41 9888888',
                    'telefone_1_wa' => true,
                    'versao' => 1,
                    'roles' => ['admin', 'super-admin', 'atendente'],
                    'permissions' => [],
                    'app_admin' => true,
                ],
                [
                    'name' => 'Atendente 1',
                    'email' => 'atendente_1@mail.com',
                    'password' => bcrypt('power@123'),
                    'email_verified_at' => now(),
                    'telefone_1' => '41 9888888',
                    'telefone_1_wa' => true,
                    'versao' => 1,
                    'roles' => ['atendente'],
                    'permissions' => [],
                    'app_admin' => true,
                ],
                [
                    'name' => 'Usuario 1',
                    'email' => 'usuario1@mail.com',
                    'password' => bcrypt('power@123'),
                    'email_verified_at' => now(),
                    'telefone_1' => '41 9888888',
                    'telefone_1_wa' => true,
                    'versao' => 1,
                    'roles' => ['usuario'],
                    'permissions' => [],
                ],
                [
                    'name' => 'Usuario 2',
                    'email' => 'usuario2@mail.com',
                    'password' => bcrypt('power@123'),
                    'email_verified_at' => now(),
                    'telefone_1' => '41 9888888',
                    'telefone_1_wa' => true,
                    'versao' => 1,
                    'roles' => ['usuario'],
                    'permissions' => [],
                ],
                [
                    'name' => 'Random Usuario 1',
                    'email' => \Str::random(7) . '@mail.com',
                    'password' => bcrypt('power@123'),
                    'email_verified_at' => now(),
                    'telefone_1' => '41 9888888',
                    'telefone_1_wa' => true,
                    'versao' => 1,
                    'roles' => ['usuario'],
                    'permissions' => [],
                ],
            ];

            foreach ($usuarios as $usuario) {
                $unidade = (\Arr::random($unidades_array));
                $usuario['ue'] = $unidade['ue'];

                $user = Usuario::updateOrcreate(['email' => $usuario['email']], Arr::except($usuario, ['roles', 'permissions']));

                if ($usuario['roles'] ?? []) {
                    $roles = Role::select('id')->whereIn('name', $usuario['roles'])->get();
                    if ($roles) {
                        $user->assignRole($roles->pluck('id'));
                    }
                }

                if ($usuario['permissions'] ?? []) {
                    $permissions = Permission::select('id')->whereIn('name', $usuario['permissions'])->get();
                    if ($permissions) {
                        $user->givePermissionTo($permissions->pluck('id'));
                    }
                }
            }
        } else {
            dump(PHP_EOL . 'Nenhuma unidade encontrada. ' . __FILE__ . ':' . __LINE__ . PHP_EOL);
        }
    }
}
