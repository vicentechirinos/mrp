<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
            ],
            [
                'name' => 'Customer',
                'slug' => 'customer',
            ],
            [
                'name' => 'Employee',
                'slug' => 'employee',
            ],
        ];

        DB::table('roles')->insert($data);
    }
}
