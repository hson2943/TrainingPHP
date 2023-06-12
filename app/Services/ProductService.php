<?php

namespace App\Services;

use App\Repositories\Product\ProductRepositoryInterface;
use App\Models\Product;

class ProductService
{
    protected $product_repo;

    public function __construct(ProductRepositoryInterface $product_repo)
    {
        $this->product_repo = $product_repo;
    }

    /**
    * Get all products based on the provided search criteria.
    *
    * @param  array  $data_search
    * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
    */
    public function getAllProducts($data_search)
    {
        return $this->product_repo->getAllProducts($data_search);
    }

    /**
    * Get a product by its ID.
    *
    * @param  int  $id
    * @return Product
    */
    public function getByID($id)
    {
        return $this->product_repo->getByID($id);
    }

    /**
    * Store a new product.
    *
    * @param  Request  $request
    * @return Product
    */
    public function store($request)
    {
        $newProduct = new Product;
        $newProduct->name = $request->product['name'];
        $newProduct->prices = $request->product['prices'];
        $newProduct->description = $request->product['description'];
        $newProduct->thumbnail = $request->product['thumbnail'];
        $newProduct->brand_id = $request->product['brand_id'];
        $newProduct->category_id = $request->product['category_id'];

        return $this->product_repo->store($newProduct);
    }

    /**
    * Update a product.
    *
    * @param  int  $id
    *
    * @param  array  $data
    *
    * @return void
    */
    public function update($id, $data)
    {
        return $this->product_repo->update($id, $data);
    }

    /**
    * Delete a product.
    *
    * @param  int  $id
    *
    * @return void
    */
    public function delete($id)
    {
        return $this->product_repo->delete($id);
    }
    
    /**
    * Get related products based on the specified product ID.
    *
    * @param  int  $id

    * @return \Illuminate\Database\Eloquent\Collection
    */
    public function getRelativeProducts($id)
    {
        return $this->product_repo->getRelativeProducts($id);
    }
}
