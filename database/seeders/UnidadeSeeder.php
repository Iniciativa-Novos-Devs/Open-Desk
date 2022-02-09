<?php

namespace Database\Seeders;

use App\Models\Unidade;
use Illuminate\Database\Seeder;
use Str;

class UnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unidades = [
            [
                'nome'    => 'Administração Central',
                'ue'      => '001',
                'cidade'  => 'São Paulo',
            ],
        ];

        if(env('APP_ENV') != 'production')
        {
            foreach(range(1, 10) as $_i)
            {
                $unidades[] = [
                    'nome'    => 'Unidade '. Str::random(10),
                    'ue'      => Str::random(3),
                    'cidade'  => Str::random(5).' '.Str::random(5),
                ];
            }
        }

        foreach ($unidades as $unidade)
        {
            if (
                !($unidade['nome'] ?? null) ||
                !($unidade['ue'] ?? null)
            )
            {
                continue;
            }

            $newData = [
                'ue'      => $unidade['ue']      ?? null,
                'nome'    => $unidade['nome']    ?? null,
                'cidade'  => $unidade['cidade']  ?? null,
                'diretor' => $unidade['diretor'] ?? null,
                'dir_adm' => $unidade['dir_adm'] ?? null,
                'versao'  => 1,
            ];

            Unidade::updateOrCreate([
                'ue' => $newData['ue'],
            ], $newData);
        }
    }
}
