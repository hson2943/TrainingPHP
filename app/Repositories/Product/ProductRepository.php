<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Config;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    protected $product_model;
    protected $limit;
    protected $limit_relative;

    public function __construct(Product $product_model)
    {
        $this->product_model = $product_model;
        $this->limit = Config::get('constants.options.pagination_limit');
        $this->limit_relative = Config::get('constants.options.limit_products_relative');
    }

    /**
    * Get all products based on the provided search criteria.
    *
    * @param  array  $data_search

    * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
    */
    public function getAllProducts($data_search)
    {
        $brand_id = isset($data_search['brand_id']) ? $data_search['brand_id'] : null;
        $category_id = isset($data_search['category_id']) ? $data_search['category_id'] : null;
        $key = isset($data_search['key']) ? $data_search['key'] : null;
        $limit = $this->limit;

        $query = Product::query()
            ->select('id', 'name', 'prices', 'thumbnail');

        //filter product with brand_id
        if ($brand_id) {
            $query->whereBrandId($brand_id);
        }

        //filter product with category_id
        if ($category_id) {
            $query->whereCategoryId($category_id);
        }

        //filter product with search key
        if ($key) {
            $query->where(function ($query) use ($key) {
                $query->where('name', 'like', '%' . $key . '%')
                    ->orWhere('id', $key);
            });
        }

        $products = $query->orderBy('id', 'desc')->paginate($limit);

        return $products;
    }

    /**
     * Get product with ID.
     * 
     * @param  int  $id
     * 
     * @return Product
     */
    public function getByID($id)
    {
        return Product::with('category', 'brand', 'gallery')->findOrFail($id);
    }

    /**
     * Get product by name product.
     * 
     * @param  Product  $data
     * 
     * @return Product 
     */
    public function store($data)
    {
        $data->save();
        return $data;
    }
    /**
    * Delete a product and its associated gallery.
    *
    * @param  int  $id

    * @return void
    */
    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->gallery()->delete();
        $product->delete();
    }

    /**
    * Update a product with the provided data.
    *
    * @param  int  $id

    * @param  array  $data

    * @return void
    */
    public function update($id, $data)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'name' => $data['name'],
            'brand_id' => $data['brand_id'],
            'category_id' => $data['category_id'],
            'prices' => $data['prices'],
            'description' => $data['description'] == "null" ? null : $data['description'],
            'thumbnail' => $data['thumbnail'],
        ]);
    }

    /**
    * Get a collection of related products based on the specified product ID.
    *
    * @param  int  $id
    
    * @return \Illuminate\Database\Eloquent\Collection
    */
    public function getRelativeProducts($id)
    {
        $product = Product::findOrFail($id);
        return Product::where('brand_id', $product->brand_id)
            ->orWhere('category_id', $product->category_id)
            ->limit($this->limit_relative)->get();
    }
}
