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
        // \App\Models\Usuario::factory(10)->create();
        // $this->call(UserSeeder::class);// 7.x e anteriores

        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UnidadeSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(UsuarioSeeder::class);

        if (env('APP_ENV') != 'production') {//Seeders apenas de ambiente for diferente de production
            $this->call(TipoProblemaSeeder::class);
            $this->call(AtividadeSeeder::class);
            $this->call(ProblemaSeeder::class);
            $this->call(ChamadoSeeder::class);
        }
    }
}
