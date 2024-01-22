<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductInventryController;

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
    Route::post('/{product_id}/basic/update', [ProductController::class, "update"])->name('product.update');
    Route::post('/{product_id}/select/product/delete', [ProductController::class, 'deleteSelectedItems'])->name('product.delete.selected');

    Route::post('/{product_id}/inventry/update', [ProductInventryController::class, "update"])->name('product.inventry.update');
    Route::get('/{product_id}/inventry/all', [ProductInventryController::class, "all"])->name('product.inventry.all');
    Route::delete('/{product_id}/inventry/delete', [ProductInventryController::class, "delete"])->name('product.inventry.delete');

});

require __DIR__.'/auth.php';


