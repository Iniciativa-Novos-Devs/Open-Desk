<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
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
            $areas = [
                [
                    'sigla'  => 'DPAT',
                    'nome'   => 'Patrimônio',
                ],
                [
                    'sigla'  => 'NTC',
                    'nome'   => 'Núcleo de tomada de contas',
                ],
            ];

            foreach ($areas as $area)
            {
                Area::updateOrCreate(
                    ['sigla' => $area['sigla']],
                    $area
                );
            }

        }

    }
}
