<?php

namespace Database\Seeders;

use App\Models\TipoProblema;
use Illuminate\Database\Seeder;

class TipoProblemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 10) as $i) {
            TipoProblema::create([
                'nome' => \Str::random(8),
                'versao' => 1,
            ]);
        }
    }
}
