<?php

namespace App\Http\Controllers;


use App\Repositories\Brand\BrandRepositoryInterface;
use Illuminate\Http\Response;

class BrandController extends Controller
{
    protected $brand_service;
    
    public function __construct(BrandRepositoryInterface $brand_service)
    {
        $this->brand_service = $brand_service;
    }

    /**
    * Get all brands.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function getAll()
    {
        $products = $this->brand_service->getAll();
        $this->setResponse(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK], $products->toArray());
        return $this->getResponse($this->status, $this->message,$this->data);
    }
}
