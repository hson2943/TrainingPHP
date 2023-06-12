<?php

namespace App\Services;

use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryService
{
    protected $category_repo;

    public function __construct(CategoryRepositoryInterface $category_repo)
    {
        $this->category_repo = $category_repo;
    }

    /**
    * Get all brands.
    *
    * @return \Illuminate\Database\Eloquent\Collection
    */
    function getAll()
    {
        return $this->category_repo->getAll();
    }
}
