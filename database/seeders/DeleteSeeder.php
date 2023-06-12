<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeleteSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    { 
            DB::table('galleries')->delete();
            DB::table('products')->delete();
            DB::table('category_brands')->delete();
            DB::table('categories')->delete();
            DB::table('brands')->delete();
    }
}
