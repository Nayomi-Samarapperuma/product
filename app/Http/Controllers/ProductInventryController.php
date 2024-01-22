<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\UpdateProductInventryRequest;
use App\Models\ProductInventry;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Resources\DataResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ParentController;
use App\Filters\FuzzyFilter;
use Carbon\Carbon;
use domain\Facades\ProductInventryFacade\ProductInventryFacade;

class ProductInventryController extends ParentController
{
    public function update(UpdateProductInventryRequest $request, int $productId)
    {
        $request['product_id'] = $productId;
        $request['date'] = Carbon::createFromFormat('d.m.Y', $request['date'])->format('Y-m-d');
        ProductInventryFacade::store($request->all());
    }

    public function all(int $productId)
    {
        $query = ProductInventry::query()->where('product_id', $productId)->orderBy('id','desc');
        $payload = QueryBuilder::for($query)
            ->allowedSorts(['id', 'name'])
            ->allowedFilters(AllowedFilter::custom('search', new FuzzyFilter('code','date','quantity','reason')))
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }

    public function delete(int $id)
    {
            return  ProductInventryFacade::delete($id);

    }
}
