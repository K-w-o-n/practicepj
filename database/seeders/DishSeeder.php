<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dishes')->insert([
            'name' => 'steak',
            'category_id' => 1,
        ]);
        DB::table('dishes')->insert([
            'name' => 'pizza',
            'category_id' => 1,
        ]);
        DB::table('dishes')->insert([
            'name' => 'plasta',
            'category_id' => 1,
        ]);
    }
}
