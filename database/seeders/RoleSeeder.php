<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Admin',
                'uid'  => 100,
            ],
            [
                'name' => 'Atendente',
                'uid'  => 200,
            ],
            [
                'name' => 'Usuario',
                'uid'  => 300,
            ],
        ];

        foreach ($roles as $role)
            Role::updateOrCreate([
                'uid'  => $role['uid'],
            ], $role);
    }
}
