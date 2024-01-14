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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });


Route::get('/', [HomeController::class, "index"])->name('dashboard');

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, "index"])->name('product.index');
    Route::get('/list/{slug}', [ProductController::class, "withSlugIndex"])->name('product.slug.index');
    Route::get('/{slug}/all/slug', [ProductController::class, "allWithSlug"])->name('product.all.slug');
    Route::get('/fg/all', [ProductController::class, "finishGood"])->name('product.fg.all');
    Route::get('/all', [ProductController::class, "all"])->name('product.all');
    Route::post('/store', [ProductController::class, "store"])->name('product.store');
    Route::delete('/{product_id}/delete', [ProductController::class, "delete"])->name('product.delete');
    Route::get('/{product_id}/edit', [ProductController::class, "edit"])->name('product.edit');
    Route::get('/{product_id}/get', [ProductController::class, "get"])->name('product.get');
    Route::get('/{product_id}/costing/print', [ProductController::class, "print"])->name('product.costing.print');

    Route::post('/{product_id}/basic/update', [ProductController::class, "update"])->name('product.basic.update');

    Route::get('/{product_id}/costing/getProducts', [ProductCostingController::class, "getProducts"])->name('product.costing.getProducts');
    Route::get('/{product_id}/costing/all', [ProductCostingController::class, "all"])->name('product.costing.all');
    Route::post('/{product_id}/costing/update', [ProductCostingController::class, "update"])->name('product.costing.update');
    Route::delete('/{costing_id}/costing/delete', [ProductCostingController::class, "delete"])->name('product.costing.delete');
    Route::get('/{product_id}/costing/get', [ProductCostingController::class, "get"])->name('product.costing.get');

    Route::get('/sizes/all', [ProductSizeController::class, "all"])->name('product.size.all');
    Route::get('/{size_slug}/size/get', [ProductSizeController::class, "get"])->name('product.size.get');

    Route::post('/{product_id}/purchasing_data/update', [ProductController::class, "updatePurchasingData"])->name('product.purchasing_data.update');
    Route::get('/{product_id}/purchasing_data/get', [ProductController::class, "getPurchasingData"])->name('product.purchasing_data.get');

    Route::post('/{product_id}/vendor_data/update', [ProductController::class, "updateVendorData"])->name('product.vendor_data.update');
    Route::get('/{product_id}/vendor_data/get', [ProductController::class, "getVendorData"])->name('product.vendor_data.get');
    Route::delete('/{vendor_id}/vendor_data/delete', [ProductController::class, "deleteVendorData"])->name('products.vendor_data.delete');

    Route::post('/{product_id}/mrp_data/update', [ProductController::class, "updateMrpData"])->name('product.mrp_data.update');
    Route::get('/{product_id}/mrp_data/get', [ProductController::class, "getMrpData"])->name('product.mrp_data.get');

    Route::post('/{product_id}/classification_data/update', [ProductController::class, "updateClassificationData"])->name('products.classification_data.update');
    Route::get('/{product_id}/classification_data/get', [ProductController::class, "getClassificationData"])->name('products.classification_data.get');
    Route::delete('/{classification_id}/classification_data/delete', [ProductController::class, "deleteClassificationData"])->name('products.classification_data.delete');

    Route::post('/select/product/delete', [ProductController::class, 'deleteSelectedItems'])->name('products.delete.selected');
    Route::post('/select/product/inactive', [ProductController::class, 'inactiveSelectedItems'])->name('products.inactive.selected');
    Route::post('/select/product/active', [ProductController::class, 'activeSelectedItems'])->name('products.active.selected');
});

require __DIR__.'/auth.php';
