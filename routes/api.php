<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShoppingCardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->group(function () {

    Route::get('list-product', [ProductController::class, 'index']);
    Route::post('list-product-store', [ProductController::class, 'store']);
    Route::put('list-product-update/{id}', [ProductController::class, 'update']);
    Route::delete('list-product-delete/{id}', [ProductController::class, 'destroy']);
    
    Route::get('list-category', [CategoryController::class, 'index']);
    Route::post('list-category-store', [CategoryController::class, 'store']);
    Route::put('list-category-update/{id}', [CategoryController::class, 'update']);
    Route::delete('list-category-delete/{id}', [CategoryController::class, 'destroy']);
    
    Route::get('list-brand', [BrandController::class, 'index']);
    Route::post('list-brand-store', [BrandController::class, 'store']);
    Route::put('list-brand-update/{id}', [BrandController::class, 'update']);
    Route::delete('list-brand-delete/{id}', [BrandController::class, 'destroy']);

    Route::get('list-color', [ColorController::class, 'index']);
    Route::post('list-color-store', [ColorController::class, 'store']);
    Route::put('list-color-update/{id}', [ColorController::class, 'update']);
    Route::delete('list-color-delete/{id}', [ColorController::class, 'destroy']);

    Route::get('list-card', [ShoppingCardController::class, 'index']);
    Route::post('add-card', [ShoppingCardController::class, 'store']);
    Route::delete('delete-card/{id}', [ShoppingCardController::class, 'destroy']);
    Route::patch('increasing-quantity-shopping/{id}', [ShoppingCardController::class, 'increasing_quantity_shoppingcard']);
    Route::patch('reduce-quantity-shopping/{id}', [ShoppingCardController::class, 'reduce_quantity_shoppingcard']);

    Route::get('list-order', [OrderController::class, 'index']);
    Route::post('order-store', [OrderController::class, 'store']);
    Route::patch('processing/{id}', [OrderController::class, 'processing']);
    Route::patch('success/{id}', [OrderController::class, 'success']);


});
Route::get('list-product-no-user', [ProductController::class, 'index']);
Route::get('product-detail/{id}', [ProductController::class, 'edit']);


Route::prefix('/user')->group(function () {
    Route::post('/login', 'LoginController@login');
});