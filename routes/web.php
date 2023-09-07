<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

Route::get('/','AuthUserController@index', function () {
    return view('welcome');
});
Route::get('/product-detail/{id}' ,'AuthUserController@product_detail');
Route::get('/card/buy-selecteds' ,'AuthUserController@buy_selected');
Route::get('/admin', 'HomeController@admin')->name('color');
Route::middleware('auth')->group(function () {
    Route::get('/setting','AuthUserController@index', [HomeController::class, 'index']);
    Route::get('/demo', [HomeController::class, 'admin'], [HomeController::class, 'category']);
    Route::get('/category' ,'AuthUserController@category');
    Route::get('/brand' ,'AuthUserController@brand');
    Route::get('/color' ,'AuthUserController@color');
    Route::get('/product' ,'AuthUserController@product');
    Route::get('/card' ,'AuthUserController@card');

});

Auth::routes();
// Route::get('/setting', 'HomeController@index');
