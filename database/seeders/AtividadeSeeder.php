<?php

namespace Database\Seeders;

use Arr;
use App\Models\Area;
use App\Models\Atividade;
use Illuminate\Database\Seeder;

class AtividadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(env('APP_DEBUG'))
        {
            $areas = Area::limit(10)->get();

            if(!$areas)
                return;

            $areas_array = $areas->toArray();

            foreach (range(1, 10) as $k)
            {
                $area = (Arr::random($areas_array));
                $atividade = [
                    'nome'      => 'Atividade fake '. $area['nome'] .' '. \Str::random(5),
                    'area_id'   => $area['id'],
                ];

                Atividade::updateOrCreate(
                    ['nome' => $atividade['nome']],
                    $atividade
                );
            }

        }

    }
}
