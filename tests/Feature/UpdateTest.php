<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;
use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateProductTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $brand;
    protected $category;
    protected $product;
    protected $update_data;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install');
        $this->user = User::factory()->create();
        $this->category = Category::factory()->create();
        $this->brand = Brand::factory()->create();


        // Create a product
        $this->product = Product::factory()->create([
            'name' => 'abc',
            'category_id' => $this->category['id'],
            'brand_id' => $this->brand['id'],
            'prices' => 123456,
            'thumbnail' => 'image.png',
            'description' => 'description',
        ]);
        // Generate updated data
        $this->update_data = [
            'name' => 'updated name',
            'prices' => 654321,
            'category_id' => 1,
            'brand_id' => 1,
            'thumbnail' => 'new_image.png',
            'description' => 'updated description',
            'galleries' => json_encode([
                [
                    'url_image' => 'gallery_image1.png',
                    'index' => 1,
                    'product_id' => $this->product->id,
                ],
                [
                    'url_image' => 'gallery_image2.png',
                    'index' => 2,
                    'product_id' => $this->product->id,
                ],
            ]),
        ];
    }
   
    protected function headers($user = null)
    {
        $headers = ['Accept' => 'application/json'];
        if (!is_null($user)) {
            $token = $user->createToken('User access token')->accessToken;
            $headers['Authorization'] = 'Bearer ' . $token;
        }
        return $headers;
    }

    public function testUpdateProduct()
    {
        $response = $this->put('/api/product/update/' . $this->product->id, $this->update_data, $this->headers($this->user));
        $response->assertOk();
    }

    public function testNoLoginCanNotUpdateProduct()
    {
        $response = $this->put('/api/product/update/' . $this->product->id, $this->update_data);
        $response->assertServerError();
    }
}
