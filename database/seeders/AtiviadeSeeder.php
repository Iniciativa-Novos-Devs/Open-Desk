<?php

namespace Database\Seeders;

use Arr;
use App\Models\Area;
use App\Models\Atividade;
use Illuminate\Database\Seeder;

class AtiviadeSeeder extends Seeder
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

            foreach (range(1, 50) as $k)
            {
                $area = (Arr::random($areas->toArray()));
                $atividade = [
                    'nome'      => 'Atividade fake '. $area['nome'] .' '. \Str::random(10),
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
