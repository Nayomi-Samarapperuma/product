<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Http\Controllers\ParentController;
use domain\Facades\ProductFacade\ProductFacade;

class ProductController extends ParentController
{
    public function index()
    {
        return Inertia::render('Products/index');
    }

    public function store(ProductRequest $request)
    {
      ProductFacade::store($request->all());
      return redirect()->back;
    }

    public function get(int $product_id)
    {
        $payload = ProductFacade::get($product_id);
        return new DataResource($payload);
    }

    public function edit(int $product_id)
    {
        $response['product'] = ProductFacade::get($product_id);
        return Inertia::render('Products/edit', $response);
    }

    public function update(UpdateProductRequest $request, int $product_id)
        {
            return ProductFacade::update($request->all(), $product_id);
        }

    public function delete(int $product_id)
    {
        return ProductFacade::delete($product_id);
    }

    public function deleteSelectedItems(Request $request)
    {
        return ProductFacade::deleteSelected($request);
    }

    public function inactiveSelectedItems(Request $request)
    {
        return ProductFacade::inactive($request);
    }

    public function activeSelectedItems(Request $request)
    {
        return ProductFacade::active($request);
    }

}



