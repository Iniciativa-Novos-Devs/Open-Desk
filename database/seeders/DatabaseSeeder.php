<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // $this->call(UserSeeder::class);// 7.x e anteriores

        if(env('APP_DEBUG'))//Seeders apenas de dev
        {
            $this->call(AreaSeeder::class);
            $this->call(AtiviadeSeeder::class);
        }
    }
}
