<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ActionSeeder extends Seeder
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
                'name' => 'Index',
                'slug' => 'index',
            ],
            [
                'name' => 'Store',
                'slug' => 'store',
            ],
            [
                'name' => 'Update',
                'slug' => 'Update',
            ],
            [
                'name' => 'Show',
                'slug' => 'show',
            ],
            [
                'name' => 'Delete',
                'slug' => 'delete',
            ],
        ];

        DB::table('actions')->insert($data);
    }
}
