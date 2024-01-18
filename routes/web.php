<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

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



Route::get('/', [HomeController::class, "index"])->name('dashboard');

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, "index"])->name('product.index');
    Route::get('/all', [ProductController::class, "all"])->name('product.all');
    Route::post('/store', [ProductController::class, "store"])->name('product.store');
    Route::delete('/{product_id}/delete', [ProductController::class, "delete"])->name('product.delete');
    Route::get('/{product_id}/edit', [ProductController::class, "edit"])->name('product.edit');
    Route::get('/{product_id}/get', [ProductController::class, "get"])->name('product.get');
    Route::post('/{product_id}/basic/update', [ProductController::class, "update"])->name('product.basic.update');
    Route::post('/{product_id}/select/product/delete', [ProductController::class, 'deleteSelectedItems'])->name('product.delete.selected');
    Route::post('/select/product/inactive', [ProductController::class, 'inactiveSelectedItems'])->name('product.inactive.selected');
    Route::post('/select/product/active', [ProductController::class, 'activeSelectedItems'])->name('product.active.selected');


});

require __DIR__.'/auth.php';


