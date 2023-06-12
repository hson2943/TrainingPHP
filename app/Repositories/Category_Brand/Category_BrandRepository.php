<?php

namespace App\Repositories\Category_Brand;

use App\Models\Category_Brand;

class Category_BrandRepository implements Category_BrandRepositoryInterface
{
    protected $cate_brand;

    public function __construct(Category_Brand $cate_brand)
    {
        $this->cate_brand = $cate_brand;
    }

    /**
    * Get brands by category ID.
    *
    * @param int $category_id The ID of the category.
    
    * @return \Illuminate\Database\Eloquent\Collection
    */
    public function getBrandByCate($category_id)
    {
        return $this->cate_brand->where('category_id', $category_id)->with('brand')->get();
    }
}
