<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ModuleSeeder extends Seeder
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
                'name' => 'Dashboard',
                'slug' => 'dashboard',
                'path' => '/',
            ],
            [
                'name' => 'User',
                'slug' => 'user',
                'path' => '/user',
            ],
            [
                'name' => 'Role',
                'slug' => 'role',
                'path' => '/role',
            ],
            [
                'name' => 'Permission',
                'slug' => 'permission',
                'path' => '/permission',
            ],
        ];

        DB::table('modules')->insert($data);
    }
}
