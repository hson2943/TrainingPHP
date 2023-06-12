<?php

namespace App\Services;

use App\Repositories\Brand\BrandRepositoryInterface;

class BrandService
{
    protected $brandRepo;

    public function __construct(BrandRepositoryInterface $brandRepo)
    {
        $this->brandRepo = $brandRepo;
    }

    /**
    * Get all brands.
    *
    * @return \Illuminate\Database\Eloquent\Collection
    */
    function getAll()
    {
        return $this->brandRepo->getAll();
    }
}
