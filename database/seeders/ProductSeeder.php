<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    { 
        for ($i = 1; $i <= 3; $i++) {
            $product = new Product([
                'name' => 'Audi Car ' . $i,
                'prices' => rand(1000, 100000),
                'description' => 'This is product ' . $i,
                'brand_id' => 4,
                'category_id' => 1,
                'thumbnail' => 'https://firebasestorage.googleapis.com/v0/b/database-image-8cf4e.appspot.com/o/images%2Faudi%20car.png?alt=media&token=49264571-cf6a-43de-95a1-eae795035abd',
            ]);
            $product->name = 'Audi Car ' . $i;
            $product->save();
        }
        for ($i = 1; $i <= 50; $i++) {
            $product = new Product([
                'name' => 'Ducati Car ' . $i,
                'prices' => rand(1000, 100000),
                'description' => 'This is product ' . $i,
                'brand_id' => 1,
                'category_id' => 1,
                'thumbnail' => 'https://firebasestorage.googleapis.com/v0/b/database-image-8cf4e.appspot.com/o/images%2Fducaticar.jpg?alt=media&token=c2ddf470-8eb3-4b3c-9bd9-6b307fdefa9b',
            ]);
            $product->name = 'Ducati Car ' . $i;
            $product->save();
        }
        for ($i = 1; $i <= 50; $i++) {
            $product = new Product([
                'name' => 'Ducati Motobike ' . $i,
                'prices' => rand(1000, 100000),
                'description' => 'This is product ' . $i,
                'brand_id' => 1,
                'category_id' => 2,
                'thumbnail' => 'https://firebasestorage.googleapis.com/v0/b/database-image-8cf4e.appspot.com/o/images%2Fstreetfighter-v4-s-2020.png?alt=media&token=9a74445f-9f66-4455-a05c-8180d8c2dfd7',
            ]);
            $product->name = 'Ducati Motobike ' . $i;
            $product->save();
        }
        for ($i = 1; $i <= 50; $i++) {
            $product = new Product([
                'name' => 'Ferrari Car ' . $i,
                'prices' => rand(1000, 100000),
                'description' => 'This is product ' . $i,
                'brand_id' => 2,
                'category_id' => 1,
                'thumbnail' => 'https://firebasestorage.googleapis.com/v0/b/database-image-8cf4e.appspot.com/o/images%2Fef027c87bf510267ab7b619a55b18f90.jpg?alt=media&token=16d329f3-b4ee-4c66-bc77-395d13703772',
            ]);
            $product->name = 'Ferrari Car ' . $i;
            $product->save();
        }
        for ($i = 1; $i <= 50; $i++) {
            $product = new Product([
                'name' => 'Bike Cycle Giant ' . $i,
                'prices' => rand(1000, 100000),
                'description' => 'This is product ' . $i,
                'brand_id' => 2,
                'category_id' => 3,
                'thumbnail' => 'https://firebasestorage.googleapis.com/v0/b/database-image-8cf4e.appspot.com/o/images%2FStateBicycleCo.xTacoBell_Klunker_FrameBagCombo-2_1024x1024.jpg?alt=media&token=1f3bfec9-acfe-4e93-898d-957a46a02f91',
            ]);
            $product->name = 'Bike Cycle Giant ' . $i;
            $product->save();
        }

    }
}
