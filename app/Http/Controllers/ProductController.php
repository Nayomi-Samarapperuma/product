<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
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

    public function store(CreateProductRequest $request)
    {
      return ProductFacade::store($request->all());
    }

    public function all()
    {
        $query = Product::orderBy('id', 'desc');
        if (request('search_vendor_code')) {
            $code = request('search_vendor_code');
            $query->where('code', $code);
        }
        if (request('search_vendor_name')) {
            $name = request('search_vendor_name');
            $query->where('name', 'like', "%{$name}%");
        }
        if (request('search_vendor_country')) {
            $contact = request('search_vendor_country');
            $query->where('contact', $contact);
        }

        $payload = QueryBuilder::for($query)
            ->allowedSorts(['code'])
            ->allowedFilters(
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->whereHas('countries', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                    $query->orWhereHas('currencies', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                    $query->orWhere('code', 'like', "%{$value}%");
                    $query->orWhere('name', 'like', "%{$value}%");
                })
            )
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
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



