<?php

namespace Database\Seeders;

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
        Usuario::create([
            'name'              => 'Nome '.Str::random(6),
            'email'             => Str::random(6).'_fake_mail@domain.'.Str::random(3).'.com',
            'password'          => Str::random(10),
            'email_verified_at' => now(),
            'telefone_1'        => '41 9888888',
            'telefone_1_wa'     => true,
            'ue'                => 1,
            'versao'            => 1,
        ]);
    }
}
