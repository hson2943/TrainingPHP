<?php

namespace App\Http\Controllers;

use App\Services\Category_BrandService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class Category_BrandController extends Controller
{
    protected $cate_brand_service;

    public function __construct(Category_BrandService $cate_brand_service)
    {
        $this->cate_brand_service = $cate_brand_service;
    }
    
    /**
    * Get brands by category ID.
    *
    * @param int $category_id The ID of the category.
    * 
    * @return \Illuminate\Http\JsonResponse
    */
    public function getBrandByCate($category_id)
    {
        $cate_brand = $this->cate_brand_service->getBrandByCate($category_id);
        $this->setResponse(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK], $cate_brand->toArray());
        return $this->getResponse($this->status, $this->message,$this->data);
    }
}
