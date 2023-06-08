<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::controller(AddressController::class)->group(function () {
    Route::get('get_cities', 'getCities');
    Route::get('get_districts_by_id_city/{idCity}', 'getDistricts');
    Route::get('get_urbans_by_id_district/{idDistrict}', 'getUrbans');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('products', 'index');
    Route::get('product/{id}', 'getProductById');
    Route::post('products_by_cate_id', 'getProductByCategoryId');
    Route::post('/upload_image', 'uploadImage');
    Route::get('/categories', 'getAllCategory');
    Route::get('/style/{id}', 'getStyleById');
    Route::get('/color/{id}', 'getColorById');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(ProductController::class)->group(function () {
        Route::get('/admin/products', 'index');
        Route::post('/admin/product/update/{id}', 'updateProduct');
        Route::post('/admin/category/create', 'createCategory');
        Route::post('/admin/product/create', 'createProduct');
        Route::post('/admin/style/update/{id}', 'updateStyle');
        Route::post('/admin/color/update/{id}', 'updateColor');
        Route::post('/admin/color/create', 'createColor');
        Route::post('/admin/style/create', 'createStyle');
    });
    Route::controller(OrderController::class)->group(function () {
        Route::post('/admin/order/create', 'createOrder');
        Route::post('/admin/order_detail/create', 'createOrderDetail');
        Route::get('/admin/order/{id}', 'getOrderById');
        Route::get('/admin/orders', 'getListOrder');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/admin/user/{id}', 'getUserById');
        Route::get('/admin/users', 'getListUser');
        Route::post('/admin/user/update/{id}', 'updateUser');
    });
});
