<?php

use App\Http\Controllers\Category;
use App\Http\Controllers\Product;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('products', [Product::class, 'index']);
Route::group(['prefix' => 'product'], function () {
    Route::post('add', [Product::class, 'store']);
    Route::get('edit/{id}', [Product::class, 'show']);
    Route::post('update/{id}', [Product::class, 'update']);
    Route::delete('delete/{id}', [Product::class, 'destroy']);
    Route::get('image/{name}', [Product::class, 'image']);
});

Route::get('categories',  [Category::class, 'index']);
Route::group(['prefix' => 'category'], function () {
    Route::post('add', [Category::class, 'store']);
    Route::get('edit/{id}', [Category::class, 'show']);
    Route::post('update/{id}', [Category::class, 'update']);
    Route::delete('delete/{id}', [Category::class, 'destroy']);
});