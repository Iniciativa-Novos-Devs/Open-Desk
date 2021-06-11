<?php

namespace Database\Seeders;

use App\Models\Usuario;
use App\Models\UsuarioRole;
use Illuminate\Database\Seeder;

class UsuarioRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start_user_emails   = [
            'adm@adm.com',
            'admin@mail.com',
            'atendente_1@mail.com',
            'usuario1@mail.com',
            'usuario2@mail.com',
        ];

        $start_users = Usuario::whereIn('email', $start_user_emails)->select('id', 'name')->get();

        foreach ($start_users as $start)
        {
            $user_name = strtolower($start->name);
            $role_uid  = 300;

            if(strpos($user_name, 'adm') !== false)
                $role_uid = 100;

            if(strpos($user_name, 'atendente') !== false)
                $role_uid = 200;

            if(strpos($user_name, 'usuario') !== false)
                $role_uid = 300;

            $new_user_role = [
                'usuario_id' => $start->id,
                'role_uid'   => $role_uid,
            ];

            UsuarioRole::updateOrCreate([
                'usuario_id' => $new_user_role['usuario_id'],
            ], $new_user_role);
        }

        $not_start_users = Usuario::whereNotIn('email', $start_user_emails)->select('id')->get();

        foreach ($not_start_users as $not_start)
        {
            $new_user_role = [
                'usuario_id' => $not_start->id,
                'role_uid'   => 300,
            ];

            UsuarioRole::updateOrCreate([
                'usuario_id' => $new_user_role['usuario_id'],
            ], $new_user_role);
        }
    }
}
