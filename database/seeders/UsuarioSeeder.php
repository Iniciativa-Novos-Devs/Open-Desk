<?php

namespace Database\Seeders;

use App\Models\Unidade;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Str;

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

        if(!$unidades)
            return;

        $unidades_array = $unidades->toArray();

        if($unidades_array)
        {
            $usuarios = [
                [
                    'name'              => 'Admin',
                    'email'             => 'adm@adm.com',
                    'password'          => bcrypt('123'),
                    'email_verified_at' => now(),
                    'telefone_1'        => '41 9888888',
                    'telefone_1_wa'     => true,
                    'versao'            => 1,
                    'app_admin'         => true,
                ],
                [
                    'name'              => 'Admin 2',
                    'email'             => 'admin@mail.com',
                    'password'          => bcrypt('power@123'),
                    'email_verified_at' => now(),
                    'telefone_1'        => '41 9888888',
                    'telefone_1_wa'     => true,
                    'versao'            => 1,
                    'app_admin'         => true,
                ],
                [
                    'name'              => 'Usuario 1',
                    'email'             => 'usuario1@mail.com',
                    'password'          => bcrypt('power@123'),
                    'email_verified_at' => now(),
                    'telefone_1'        => '41 9888888',
                    'telefone_1_wa'     => true,
                    'versao'            => 1,
                ],
                [
                    'name'              => 'Usuario 2',
                    'email'             => 'usuario2@mail.com',
                    'password'          => bcrypt('power@123'),
                    'email_verified_at' => now(),
                    'telefone_1'        => '41 9888888',
                    'telefone_1_wa'     => true,
                    'versao'            => 1,
                ],
            ];

            foreach ($usuarios as $usuario)
            {

                $unidade        = (\Arr::random($unidades_array));
                $usuario['ue']  = $unidade['ue'];

                Usuario::updateOrcreate(['email' => $usuario['email']], $usuario);
            }
        }else
            dump(PHP_EOL.'Nenhuma unidade encontrada. '. __FILE__.':'.__LINE__.PHP_EOL);
    }
}
