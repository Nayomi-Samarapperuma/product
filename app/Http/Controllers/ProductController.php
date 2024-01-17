<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use domain\Facades\ProductFacade\ProductFacade;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\Query\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\DataResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ParentController;
use Inertia\Inertia;


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



