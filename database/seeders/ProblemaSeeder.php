<?php

namespace Database\Seeders;

use App\Models\Atividade;
use App\Models\Problema;
use Illuminate\Database\Seeder;

class ProblemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $atividades = Atividade::select('id')->limit(30)->get();

        if (! $atividades) {
            return;
        }

        $atividades_array = $atividades->toArray();

        if ($atividades_array) {
            foreach (range(1, 20) as $i) {
                $atividade = (\Arr::random($atividades_array));

                Problema::create([
                    'descricao' => 'Problema '.\Str::random(8),
                    'atividade_area_id' => $atividade['id'],
                ]);
            }
        } else {
            dump(PHP_EOL.'Nenhuma atividade encontrada. '.__FILE__.':'.__LINE__.PHP_EOL);
        }
    }
}
