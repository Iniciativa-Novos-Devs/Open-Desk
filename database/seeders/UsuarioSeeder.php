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
            foreach (range(1, 20) as $i)
            {
                $unidade = (\Arr::random($unidades_array));

                Usuario::create([
                    'name'              => 'Nome '.Str::random(6),
                    'email'             => Str::random(6).'_fake_mail@domain.'.Str::random(3).'.com',
                    'password'          => Str::random(10),
                    'email_verified_at' => now(),
                    'telefone_1'        => '41 9888888',
                    'telefone_1_wa'     => true,
                    'ue'                => $unidade['ue'],
                    'versao'            => 1,
                ]);
            }
        }else
        dump(PHP_EOL.'Nenhuma unidade encontrada. '. __FILE__.':'.__LINE__.PHP_EOL);
    }
}
