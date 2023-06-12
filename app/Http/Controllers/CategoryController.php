<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    protected $category_service;
    
    public function __construct(CategoryService $category_service)
    {
        $this->category_service = $category_service;
    }

    /**
    * Get all categories.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function getAll()
    {
        $products = $this->category_service->getAll();
        $this->setResponse(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK], $products->toArray());
        return $this->getResponse($this->status, $this->message,$this->data);
    }
}
