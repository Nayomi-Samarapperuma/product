<?php

namespace domain\Services\ProductService;

use App\Models\Product;
use App\Models\ConsignmentItem;
use App\Models\ProductClassification;
use App\Models\ProductForeignTrade;
use App\Models\ProductForeignTradeCustomDuty;
use App\Models\ProductForeignTradeTestReport;
use App\Models\ProductRequirementPlanning;
use App\Models\ProductVendor;
use App\Models\Measurement;
use App\Models\PurchasingData;
use App\Models\WarehouseData;
use domain\Facades\ImageFacade\ImageFacade;
use domain\Facades\ProductCategoryFacade\ProductCategoryFacade;
use domain\Facades\ProductTypesFacade\ProductTypesFacade;
use Intervention\Image\Facades\Image;
use PDF;

/**
 * ProductService
 *
 * @category Service
 * @author   CyberElysium <contact@cyberelysium.com>
 * @license  https://cyberelysium.com Config
 * @link     https://cyberelysium.com
 * */
class ProductService
{

    protected $product;
    protected $product_id;
    protected $consignment;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->product = new Product();
        // $this->consignment = new ConsignmentItem();
    }

    /**
     * All
     * retrieve all the data from Product model
     *
     * @return void
     */
    public function all()
    {
        return $this->product->all();
    }

    public function productsCount()
    {
        return $this->product->count();
    }

    /**
     * Store
     * store data in database
     *
     * @param  array $data
     * @return void
     */
    public function store(array $data)
    {
        $product_item =  $this->product->create($data);
        return $product_item;
    }

    /**
     * Get
     * retrieve relevant data using product_id
     *
     * @param  int  $product_id
     * @return void
     */
    public function get(int $product_id)
    {
        return $this->product->find($product_id)->load('images');
    }

    /**
     * Update
     * update existing data using product_id
     *
     * @param  array $data
     * @param  int   $product_id
     * @return void
     */
    public function update(array $data, int $product_id)
    {
        $product = $this->product->find($product_id);
        return $product->update($this->edit($product, $data));
    }


    /**
     * Edit
     * merge data which retrieved from update function as an array
     *
     * @param  product $product
     * @param  array    $data
     * @return void
     */
    protected function edit(product $product, array $data)
    {
        return array_merge($product->toArray(), $data);
    }

    /**
     * Delete
     * delete specific data using product_id
     *
     * @param  int  $product_id
     * @return void
     */
    public function delete(int $product_id)
    {
        $product = $this->product->find($product_id);
        return $product->delete();
    }

    /**
     * deleteForce
     *
     * @param  int $product_id
     * @return void
     */
    public function deleteForce(int $product_id)
    {
        $product = $this->product->find($product_id);
        $product->forceDelete();
    }

    /**
     * getProductForBom
     *
     * @return void
     */
    public function getProductForBom()
    {
        return $this->product->getProductForBom();
    }

    public function finishGood()
    {
        return $this->product->getFinishGood();
    }

    public function bulkUpdate(int $id, array $data)
    {
        $product = $this->product->find($id);
        $product->cost = $data['cost'];
        $product->selling_price = $data['selling_price'];
        $product->save();
    }

    public function getByCode($barcode)
    {
        return $this->product->getByCode($barcode);
    }
    public function deleteSelected($data)
    {
        $ids = $data->input('ids');
        Product::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    public function inactive($data)
    {
        $ids = $data->input('ids');

        $products = Product::whereIn('id', $ids)->get();

        foreach ($products as $product) {
            $product->status = 0;
            $product->update();
        }

        return response()->json([
            'success' => true,
        ]);
    }
    public function active($data)
    {
        $ids = $data->input('ids');

        $products = Product::whereIn('id', $ids)->get();

        foreach ($products as $product) {
            $product->status = 1;
            $product->update();
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
