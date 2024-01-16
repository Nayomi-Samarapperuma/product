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
         $response ['product'] = ProductFacade::all();
        return Inertia::render('Products/index',$response);
    }
    
    /**
     * store
     *
     * @param  ProductRequest $request
     * @return void
     */
    public function store(ProductRequest $request)
    {
      ProductFacade::store($request->all());
      return redirect()->back;
    }


    /**
     * delete
     *
     * @param  int $product_id
     * @return void
     */
    public function delete(int $product_id)
    {
        ProductFacade::delete($product_id);
        return redirect()->back();
    }

    /**
     * edit
     *
     * @param  int $product_id
     * @return void
     */
    public function edit(int $product_id)
    {
        ProductFacade::edit($product_id->all());
        return redirect()->back;
    }

    /**
     * get
     *
     * @param  int $product_id
     * @return void
     */
    public function get(int $product_id)
    {
        $payload = ProductFacade::get($product_id);
        return new DataResource($payload);
    }

    /**
     * update
     *
     * @param  UpdateProductBasicRequest $request
     * @param  int $product_id
     * @return void
     */
    public function update(UpdateProductBasicRequest $request, int $product_id)
        {
            ProductFacade::update($request->all(), $product_id);
            return redirect()->route('product.index')->with($response);
        }

}



