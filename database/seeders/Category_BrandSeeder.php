<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Category_BrandSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    { 
        DB::table('category_brands')->insert([
            ['category_id' => 1, 'brand_id' => 4,],
            ['category_id' => 2, 'brand_id' => 1],
            ['category_id' => 1, 'brand_id' => 1],
            ['category_id' => 1, 'brand_id' => 2],
            ['category_id' => 1, 'brand_id' => 3],
            ['category_id' => 3, 'brand_id' => 5],
        ]);

    }
}
