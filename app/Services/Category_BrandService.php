<?php

namespace App\Services;

use App\Repositories\Category_Brand\Category_BrandRepositoryInterface;

class Category_BrandService
{
    protected $cate_brand_repo;

    public function __construct(Category_BrandRepositoryInterface $cate_brand_repo)
    {
        $this->cate_brand_repo = $cate_brand_repo;
    }

    /**
    * Get brands by category.
    *
    * @param int $category_id The ID of the category.
    
    * @return \Illuminate\Database\Eloquent\Collection
    */
    public function getBrandByCate($category_id)
    {
        return $this->cate_brand_repo->getBrandByCate($category_id);
    }

}
