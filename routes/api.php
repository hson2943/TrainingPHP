<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\Category_BrandController;
use App\Http\Controllers\AuthController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/details/{id}', [ProductController::class, 'getByID']);
Route::get('brands', [BrandController::class, 'getAll']);
Route::get('categories', [CategoryController::class, 'getAll']);
Route::get('product/{id}/relativeProducts', [ProductController::class, 'getRelativeProducts']);
Route::get('brandByCategory/{id}', [Category_BrandController::class, 'getBrandByCate']);


Route::post('products', [ProductController::class, 'getAllProducts']);
Route::post('login', [AuthController::class, 'login'])->name("login");
Route::post('register', [AuthController::class, 'register']);

Route::get('galleries/{id}', [GalleryController::class, 'getGalleryByIdProduct']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::prefix('/product')->group(function () {
        Route::post('/store', [ProductController::class, 'store']);
        Route::put('/update/{id}', [ProductController::class, 'update']);
        Route::delete('/delete/{id}', [ProductController::class, 'delete']);
    });
    Route::post('logout', [AuthController::class, 'logout']);
});


