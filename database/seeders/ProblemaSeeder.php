<?php

namespace Database\Seeders;

use App\Models\Problema;
use App\Models\TipoProblema;
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
        $tipo_problemas = TipoProblema::select('id')->limit(30)->get();

        if(!$tipo_problemas)
            return;

        $tipo_problemas_array = $tipo_problemas->toArray();

        foreach (range(1, 20) as $i)
        {
            $tipo_problema = (\Arr::random($tipo_problemas_array));

            Problema::create([
                'descricao'   =>  'Problema '. \Str::random(8),
                'atividade_area_id' => $tipo_problema['id'],
            ]);
        }
    }
}
