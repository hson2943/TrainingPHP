<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Services\GalleryService;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Response;

class ProductController extends Controller
{

    protected $productService;
    protected $galleryService;

    public function __construct(ProductService $productService, GalleryService $galleryService)
    {
        $this->productService = $productService;
        $this->galleryService = $galleryService;
    }

    /**
    * Get all products based on the provided request.
    *
    * @param  \Illuminate\Http\Request  $request

    * @return \Illuminate\Http\JsonResponse
    */
    public function getAllProducts(Request $request)
    {
        $data_search = $request->all();
        $products = $this->productService->getAllProducts($data_search);
         $this->setResponse(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK], $products->toArray());
         return $this->getResponse($this->status, $this->message,$this->data);
    }
    
    /**
    * Store a new product based on the provided request.
    *
    * @param  \Illuminate\Http\Request  $request

    * @return \Illuminate\Http\JsonResponse
    */
    public function store(Request $request)
    {
        // $product = $request->all();
        $product = $this->productService->store( $request);
        $this->setResponse(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK], $product->toArray());
        return $this->getResponse($this->status, $this->message,$this->data);
    }

    /**
    * Get a product by its ID.
    *
    * @param  int  $id

    * @return \Illuminate\Http\JsonResponse
    */
    public function getByID($id)
    {
        $products = $this->productService->getById($id);
        $this->setResponse(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK], $products->toArray());
        return $this->getResponse($this->status, $this->message,$this->data);
    }

    /**
    * Update a product based on the provided request and product ID.
    *
    * @param  \Illuminate\Http\Request  $request

    * @param  int  $product_id

    * @return \Illuminate\Http\JsonResponse
    */
    public function update(Request $request, $product_id)
    {
        $product = $request->all();
        $this->productService->update($product_id, $product);
        $galleries = json_decode($product['galleries']);
        $this->galleryService->updateGallery($galleries, $product_id);
        $this->setResponse(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK], $product);
        return $this->getResponse($this->status, $this->message,$this->data);
    }
 
    /**
    * Delete a product by its ID.
    *
    * @param  int  $id

    * @return \Illuminate\Http\JsonResponse
    */
    public function delete($id)
    {
        $this->productService->delete($id);
        $this->setResponse(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK],[]);
        return $this->getResponse($this->status, $this->message,$this->data);
    }
    
    /**
    * Get a list of relative products based on the provided product ID.
    *
    * @param  int  $id
    
    * @return \Illuminate\Http\JsonResponse
    */
    public function getRelativeProducts($id)
    {
        $list_products = $this->productService->getRelativeProducts($id);
        $this->setResponse(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK], $list_products->toArray());
        return $this->getResponse($this->status, $this->message,$this->data);
    }
}
