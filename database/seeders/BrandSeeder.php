<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    { 
        Brand::create(['id'=> 1, 'name' => 'Toyota']);
        Brand::create(['id'=> 2,'name' => 'BMW']);
        Brand::create(['id'=> 3,'name' => 'Kia']);
        Brand::create(['id'=> 4,'name' => 'Audi']);
        Brand::create(['id'=> 5,'name' => 'Giant']);
    }
}
