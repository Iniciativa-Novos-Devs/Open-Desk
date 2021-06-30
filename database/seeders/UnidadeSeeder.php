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
        foreach (range(0, 10) as $i)
        {
            Unidade::create([
                'ue'      => 'ue '.Str::random(2).rand(0, 300).rand(0, 3000),
                'nome'    => 'Unidade '.Str::random(10),
                'cidade'  => 'Sao Paulo',
                'diretor' => 'diretor '.Str::random(5),
                'dir_adm' => 'dir_adm '.Str::random(6),
                'versao'  => 1,
            ]);
        }
    }
}
