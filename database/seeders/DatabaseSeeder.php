<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    { 
        $this->call([
            BrandSeeder::class,
            CategorySeeder::class,
            // ProductSeeder::class,
            Category_BrandSeeder::class,
            // DeleteSeeder::class,
        ]);
    }
}
