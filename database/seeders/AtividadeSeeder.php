<?php

namespace Database\Seeders;

use Arr;
use Str;
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
        $areas = Area::select('id')->limit(30)->get();

        if(!$areas)
            return;

        $areas_array = $areas->toArray();

        if($areas_array)
        {
            foreach (range(1, 20) as $i)
            {
                $area = (\Arr::random($areas_array));

                Atividade::create([
                    'nome'    => 'Atividade '. Str::random(2),
                    'area_id' => $area['id'],
                ]);
            }
        }else
        dump(PHP_EOL.'Nenhuma area encontrada. '. __FILE__.':'.__LINE__.PHP_EOL);
    }
}
