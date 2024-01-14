<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Http\Controllers\ParentController;
use domain\Facades\ProductFacade\ProductFacade;
use domain\Facades\ImageFacade\ImageFacade;
use domain\Facades\ProductTypesFacade\ProductTypesFacade;
use App\Models\ProductType;


class ProductController extends ParentController
{
    public function index()
    {
        if (Auth::user()->can('read_products')) {
            return Inertia::render('Products/index');
        } else {
            $response['alert-danger'] = 'You do not have permission to read products.';
            return redirect()->route('dashboard')->with($response);
        }
    }

    public function withSlugIndex(string $slug)
    {
        $response['slug'] = $slug;
        return Inertia::render('Products/slug', $response);
    }

    public function allWithSlug(string $slug)
    {
        $id = ProductTypesFacade::getWithSlug($slug)->id;
        $query =  Product::query()->where('type', $id)->orderBy('id', 'asc');
        if (request('search_product_code')) {
            $code = request('search_product_code');
            $query->where('code', $code);
        }
        if (request('search_product_barcode')) {
            $barcode = request('search_product_barcode');
            $query->where('barcode', $barcode);
        }
        if (request('search_product_name')) {
            $name = request('search_product_name');
            $query->where('name', $name);
        }
        if (request('search_product_category')) {
            $cat_id = request('search_product_category');
            $query->whereHas('categoryData', function (Builder $query) use ($cat_id) {
                $query->where('category_l1_id', $cat_id)->orWhere('category_l2_id', $cat_id)->orWhere('category_l3_id', $cat_id)->orWhere('category_l4_id', $cat_id);
            });
        }
        $payload = QueryBuilder::for($query)
            ->allowedSorts(['code', 'description'])
            ->allowedFilters(
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->whereHas('purchaseUomData', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                    $query->orWhereHas('stockUomData', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                    $query->orWhereHas('typeData', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                    $query->orWhere('code', 'like', "%{$value}%");
                    $query->orWhere('name', 'like', "%{$value}%");
                    $query->orWhere('barcode', 'like', "%{$value}%");
                    $query->orWhere('cost', 'like', "%{$value}%");
                }),
            )
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }

    /**
     * store
     *
     * @param  ProductRequest $request
     * @return void
     */
    public function store(ProductRequest $request)
    {
        if (Auth::user()->can('create_products')) {
            return ProductFacade::store($request->all());
        } else {
            $response['alert-danger'] = 'You do not have permission to create products.';
            return redirect()->route('product.index')->with($response);
        }
    }

    /**
     * all
     *
     * @return void
     */
    public function all()
    {
        // dd(request('search_product'));
        $query =  Product::orderBy('id', 'desc');
        if (request('search_product_code')) {
            $code = request('search_product_code');
            $query->where('code', 'like', "%{$code}%");
        }
        if (request('search_product_barcode')) {
            $barcode = request('search_product_barcode');
            $query->where('barcode', 'like', "%{$barcode}%");
        }
        if (request('search_product_name')) {
            $name = request('search_product_name');
            $query->where('name', 'like', "%{$name}%")->orWhere('description', 'like', "%{$name}%");
        }
        if (request('search_product_category')) {
            $cat_id = request('search_product_category');
            $query->orWhereHas('categoryData', function (Builder $query) use ($cat_id) {
                $query->where('category_l1_id', $cat_id);
                // $query->where('category_l1_id', $cat_id)->orWhere('category_l2_id', $cat_id)->orWhere('category_l3_id', $cat_id)->orWhere('category_l4_id', $cat_id);
            });
        }
        $payload = QueryBuilder::for($query)
            ->allowedSorts(['code', 'description'])
            ->allowedFilters(
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->whereHas('purchaseUomData', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                    $query->orWhereHas('stockUomData', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                    $query->orWhereHas('categoryData', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                    $query->orWhereHas('typeData', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                    $query->orWhere('code', 'like', "%{$value}%");
                    $query->orWhere('name', 'like', "%{$value}%");
                    $query->orWhere('description', 'like', "%{$value}%");
                    $query->orWhere('barcode', 'like', "%{$value}%");
                    $query->orWhere('cost', 'like', "%{$value}%");
                })
            )
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }

    /**
     * delete
     *
     * @param  int $product_id
     * @return void
     */
    public function delete(int $product_id)
    {
        if (Auth::user()->can('delete_products')) {
            return ProductFacade::delete($product_id);
        } else {
            $response['alert-danger'] = 'You do not have permission to delete products.';
            return redirect()->route('product.index')->with($response);
        }
    }

    /**
     * edit
     *
     * @param  int $product_id
     * @return void
     */
    public function edit(int $product_id)
    {
        if (Auth::user()->can('view_products')) {
            $response['product'] = ProductFacade::get($product_id);
            return Inertia::render('Products/edit', $response);
        } else {
            $response['alert-danger'] = 'You do not have permission to edit products.';
            return redirect()->route('product.index')->with($response);
        }
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
        if (Auth::user()->can('update_products')) {
            if ($request['photo']) {
                $img = Image::make($request['photo']);
                $img->resize(null, 200, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(storage_path('app/public/' . $request['photo']->hashName()));
                // get image file from public folder
                $image = storage_path('app/public/' . $request['photo']->hashName());

                $image = ImageFacade::store($image);
                $request['image'] = $image->id;
            }
            ProductFacade::update($request->all(), $product_id);
        } else {
            $response['alert-danger'] = 'You do not have permission to update products.';
            return redirect()->route('product.index')->with($response);
        }
    }

    /**
     * update
     *
     * @param  UpdateProductPurchasingDataRequest $request
     * @param  int $product_id
     * @return void
     */

    public function updatePurchasingData(UpdateProductPurchasingDataRequest $request, int $product_id)
    {
        PurchasingDataFacade::updatePurchasing($request->all(), $product_id);
    }

    /**
     * updateVendorData
     *
     * @param  UpdateProductVendorDataRequest $request
     * @param  int $product_id
     * @return void
     */
    public function updateVendorData(UpdateProductVendorDataRequest $request, int $product_id)
    {
        if ($request['photo']) {
            $img = Image::make($request['photo']);
            $img->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save(storage_path('app/public/' . $request['photo']->hashName()));
            // get image file from public folder
            $image = storage_path('app/public/' . $request['photo']->hashName());

            $image = ImageFacade::store($image);
            $request['image'] = $image->id;
        }

        $request['product_id'] = $product_id;
        VendorDataFacade::store($request->toArray());
    }


    /**
     * print
     *
     * @param  int $product_id
     * @return void
     */
    public function print(int $product_id)
    {
        $response['costing'] = ProductFacade::get($product_id);
        $pdf = PDF::loadView('print.pages.costing', $response);
        return $pdf->stream("Product_Costing.pdf", array("Attachment" => false));
    }

    public function finishGood()
    {
        return ProductFacade::finishGood();
    }

    public function allFg()
    {
        $fg = ProductType::where('type', 'finish-good')->get()->first();
        // dd($fg->id);
        $query =  Product::query()->where('type', $fg->id)->orderBy('id', 'asc');
        if (request('search_product_code')) {
            $code = request('search_product_code');
            $query->where('code', $code);
        }
        if (request('search_product_barcode')) {
            $barcode = request('search_product_barcode');
            $query->where('barcode', $barcode);
        }
        if (request('search_product_name')) {
            $name = request('search_product_name');
            $query->where('name', $name);
        }
        if (request('search_product_category')) {
            $cat_id = request('search_product_category');
            $query->whereHas('categoryData', function (Builder $query) use ($cat_id) {
                $query->where('category_l1_id', $cat_id)->orWhere('category_l2_id', $cat_id)->orWhere('category_l3_id', $cat_id)->orWhere('category_l4_id', $cat_id);
            });
        }
        $payload = QueryBuilder::for($query)
            ->allowedSorts(['code', 'description'])
            ->allowedFilters(
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->whereHas('purchaseUomData', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                    $query->orWhereHas('stockUomData', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                    $query->orWhereHas('typeData', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                    $query->orWhere('code', 'like', "%{$value}%");
                    $query->orWhere('name', 'like', "%{$value}%");
                    $query->orWhere('barcode', 'like', "%{$value}%");
                    $query->orWhere('cost', 'like', "%{$value}%");
                }),
            )
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }

    public function getPurchasingData(int $product_id)
    {
        $payload = PurchasingDataFacade::getPurchasingData($product_id);
        return $payload;
    }

    public function getVendorData(int $product_id)
    {
        $payload = VendorDataFacade::getVendorData($product_id);
        return new DataResource($payload);
    }

    public function updateMrpData(UpdateProductMrpDataRequest $request, int $product_id)
    {
        MRPFacade::updateMrpData($request->all(), $product_id);
    }

    public function getMrpData(int $product_id)
    {
        $payload = MRPFacade::getMrpData($product_id);
        return $payload;
    }

    public function updateClassificationData(UpdateProductClassificationDataRequest $request, int $product_id)
    {
        $request['product_id'] = $product_id;
        ClassificationFacade::store($request->toArray());
    }

    public function getClassificationData(int $product_id)
    {
        $payload = ClassificationFacade::getAllClassifications($product_id);
        return new DataResource($payload);
    }

    public function deleteClassificationData(int $classification_id)
    {
        ClassificationFacade::delete($classification_id);
    }

    public function deleteVendorData(int $vendor_id)
    {
        VendorDataFacade::delete($vendor_id);
    }

    public function deleteSelectedItems(Request $request)
    {
        return ProductFacade::deleteSelected($request);
    }

    public function inactiveSelectedItems(Request $request)
    {
        if (Auth::user()->can('inactive_products')) {
            return ProductFacade::inactive($request);
        } else {
            $response['alert-danger'] = 'You do not have permission to inactive products.';
            return redirect()->route('product.index')->with($response);
        }
    }
    public function activeSelectedItems(Request $request)
    {
        if (Auth::user()->can('active_products')) {
            return ProductFacade::active($request);
        } else {
            $response['alert-danger'] = 'You do not have permission to inactive products.';
            return redirect()->route('product.index')->with($response);
        }
    }
}



