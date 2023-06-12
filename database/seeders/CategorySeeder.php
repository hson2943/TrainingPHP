<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    { 
        Category::create(['id'=>1, 'name' => 'Ô Tô']);
        Category::create(['id'=>2,'name' => 'Xe Máy']);
        Category::create(['id'=>3,'name' => 'Xe Đạp']);
    }
}
