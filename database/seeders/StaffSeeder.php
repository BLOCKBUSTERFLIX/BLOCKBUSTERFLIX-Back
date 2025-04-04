<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staff = [
            [
                'id'         => 1,
                'first_name' => 'Mike',
                'last_name'  => 'Hillyer',
                'address_id' => 3,
                'picture'    => null,
                'email'      => 'MinLyssa21@hotmail.com',
                
                'username'   => 'Mike',
                'password'   => Hash::make('contrasena'),
                'role_id'   => 2,
                'created_at' => '2006-02-15 03:57:16',
                'updated_at' => '2006-02-15 03:57:16',
            ],
            [
                'id'         => 2,
                'first_name' => 'Fernando',
                'last_name'  => 'Zapata',
                'address_id' => 4,
                'picture'    => null,
                'email'      => 'jafetavalos49@gmail.com',
                
                'username'   => 'Jon',
                'password'   => Hash::make('jafetavalos49@gmail.com'),
                'role_id'   => 2,
                'created_at' => '2006-02-15 03:57:16',
                'updated_at' => '2006-02-15 03:57:16',
            ],
            [
                'id'         => 3,
                'first_name' => 'Jess',
                'last_name'  => 'Juarez',
                'address_id' => 4,
                'picture'    => null,
                'email'      => 'jljh1993@gmail.com',
                
                'username'   => 'Iceli',
                'password'   => Hash::make('jljh1993@gmail.com'),
                'role_id'   => 3,
                'created_at' => '2006-02-15 03:57:16',
                'updated_at' => '2006-02-15 03:57:16',
            ],
            [
                'id'         => 4,
                'first_name' => 'Lizeth',
                'last_name'  => 'Hernandez',
                'address_id' => 4,
                'picture'    => null,
                'email'      => 'lizethjh17@gmail.com',
                
                'username'   => 'Jeli',
                'password'   => Hash::make('lizethjh17@gmail.com'),
                'role_id'   => 1,
                'created_at' => '2006-02-15 03:57:16',
                'updated_at' => '2006-02-15 03:57:16',
            ],
        ];

        DB::table('staff')->insert($staff);
    }
}
