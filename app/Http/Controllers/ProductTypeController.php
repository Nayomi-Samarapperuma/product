<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\ParentController;
use App\Http\Requests\Settings\ProductTypeRequest;
use App\Http\Requests\Settings\ProductType\UpdateProductTypeRequest;
use domain\Facades\ProductTypesFacade\ProductTypesFacade;
use App\Models\ProductType;
use App\Filters\FuzzyFilter;
use App\Http\Resources\DataResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Auth;

class ProductTypeController extends ParentController
{
    /**
     * Index
     *
     * @return void
     */
    public function index()
    {
        if (Auth::user()->can('read_types')) {
            return Inertia::render('Settings/ProductTypes/all');
        } else {
            $response['alert-danger'] = 'You do not have permission to read product types.';
            return redirect()->route('dashboard')->with($response);
        }
    }

    /**
     * all
     *
     * @return void
     */
    public function all()
    {
        $query = ProductType::orderBy('id', 'desc');
        $payload = QueryBuilder::for($query)
            ->allowedSorts(['code', 'name'])
            ->allowedFilters(AllowedFilter::custom('search', new FuzzyFilter('name','code')))
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }

    /**
     * store
     *
     * @param  ProductTypeRequest $request
     * @return void
     */
    public function store(ProductTypeRequest $request)
    {
        if (Auth::user()->can('create_types')) {
            return ProductTypesFacade::store($request->all());
        } else {
            $response['alert-danger'] = 'You do not have permission to create product types.';
            return redirect()->route('productType.index')->with($response);
        }
    }

    /**
     * delete
     *
     * @param  int $id
     * @return void
     */
    public function delete(int $type_id)
    {
        if (Auth::user()->can('delete_types')) {
            return ProductTypesFacade::delete($type_id);
        } else {
            $response['alert-danger'] = 'You do not have permission to delete Product types.';
            return redirect()->route('productType.index')->with($response);
        }

    }

    /**
     * get
     *
     * @param  int $id
     * @return void
     */
    public function get(int $type_id)
    {
        $payload = ProductTypesFacade::get($type_id);
        return new DataResource($payload);
    }

    /**
     * update
     *
     * @param  UpdateProductTypeRequest $request
     * @param  int $type_id
     * @return void
     */
    public function update(UpdateProductTypeRequest $request, int $type_id)
    {
        if (Auth::user()->can('update_types')) {
            return ProductTypesFacade::update($request->all(),$type_id);
        } else {
            $response['alert-danger'] = 'You do not have permission to update product types.';
            return redirect()->route('productType.index')->with($response);
        }

    }

    /**
     * allList
     *
     * @return void
     */
    public function allList()
    {
        return ProductTypesFacade::all();
    }
}
