<?php

namespace App\Repositories\Brand;

use App\Models\Brand;

class BrandRepository implements BrandRepositoryInterface
{
    protected $brand;

    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    /**
     * Get all brand.
     * 
     * @return Brand
     */
    public function getAll()
    {
        return $this->brand->all();
    }
}
