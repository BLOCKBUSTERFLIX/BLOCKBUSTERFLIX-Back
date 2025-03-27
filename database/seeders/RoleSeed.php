<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeed extends Seeder
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
                'id'         => 1,
                'role'         => "Admin",
            ],
            [
                'id'         => 2,
                'role'         => "Usuario",
            ],
            [
                'id'         => 3,
                'role'         => "Invitado",
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}
