<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\OrderController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'home.index');

Route::get('/auth/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/auth', [AuthController::class, 'store']);
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/users/create', [UserController::class, 'create'])->middleware('guest');
Route::post('/users', [UserController::class, 'store'])->middleware('guest');

Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/{category}', [CategoryController::class, 'show'])->where('category', '[0-9]+');

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show'])->where('product', '[0-9]+');

Route::middleware('auth')->group(function () {
    Route::get('/category/create', [CategoryController::class, 'create'])->middleware('can:add,App\Models\Category');
    Route::post('/category', [CategoryController::class, 'store'])->middleware('can:add,App\Models\Category');
    Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->middleware('can:update,category');
    Route::patch('/category/{category}', [CategoryController::class, 'update'])->middleware('can:update,category');

    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::get('/users/{user}/categories', [UserController::class, 'showCategories']);
    Route::get('/users/{user}/products', [UserController::class, 'showProducts']);
    Route::get('/users/{user}/image', [UserController::class, 'image'])->where('user', '[0-9]+');
    Route::post('/users/{user}/image', [UserController::class, 'storeImage'])->where('user', '[0-9]+');
    Route::delete('/users/{user}/delete', [UserController::class, 'deleteImage'])->where('user', '[0-9]+');

    Route::get('/products/create', [ProductController::class, 'create'])->middleware('can:add,App\Models\Product');
    Route::post('/products', [ProductController::class, 'store'])->middleware('can:add,App\Models\Product');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->middleware('can:update,product');
    Route::put('/products/{product}', [ProductController::class, 'update'])->middleware('can:update,product');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->middleware('can:delete,product');


    Route::get('/basket', [BasketController::class, 'show']);
    Route::post('/basket/store', [BasketController::class, 'store']);
    Route::put('/basket', [BasketController::class, 'update']);
    Route::delete('/basket/products/{product}', [BasketController::class, 'destroy'])->where('product', '[0-9]+');
    Route::get('/basket/checkout', [BasketController::class, 'showAddress']);
    Route::post('/basket/checkout', [BasketController::class, 'storeOrder']);

    Route::get('/orders/{order}', [OrderController::class, 'show']);


});
