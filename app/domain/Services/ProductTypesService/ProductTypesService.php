<?php

namespace domain\Services\ProductTypesService;

use Illuminate\Support\Str;
use App\Models\ProductType;

/**
 * ProductTypesService
 * php version 8
 *
 * @category Service
 * @author   CyberElysium <contact@cyberelysium.com>
 * @license  https://cyberelysium.com Config
 * @link     https://cyberelysium.com
 * */
class ProductTypesService
{
    protected $product_type;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->product_type = new ProductType();
    }

    /**
     * All
     * retrieve all the data from ProductType model
     *
     * @return void
     */
    public function all()
    {
        return $this->product_type->all();
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
        return $this->product_type->create($data);
    }

    /**
     * Get
     * retrieve relevant data using mat_typeId
     *
     * @param  int  $mat_typeId
     * @return void
     */
    public function get(int $mat_typeId)
    {
        return $this->product_type->find($mat_typeId);
    }

    public function getWithSlug(string $slug)
    {
        return $this->product_type->getWithSlug($slug);
    }

    /**
     * Update
     * update existing data using mat_typeId
     *
     * @param  array $data
     * @param  int   $mat_typeId
     * @return void
     */
    public function update(array $data, int $mat_typeId)
    {
        $product_type = $this->product_type->find($mat_typeId);
        $data['slug'] = Str::slug($data['name']);
        return $product_type->update($this->edit($product_type, $data));
    }

    /**
     * Edit
     * merge data which retrieved from update function as an array
     *
     * @param  mixed $product_type
     * @param  mixed $data
     * @return void
     */
    protected function edit(ProductType $product_type, $data)
    {
        return array_merge($product_type->toArray(), $data);
    }

    /**
     * Delete
     * delete specific data using mat_typeId
     *
     * @param  mixed $mat_typeId
     * @return void
     */
    public function delete($mat_typeId)
    {
        return $this->product_type->find($mat_typeId)->delete();
    }
    public function deleteSelected($data)
    {
        $ids = $data->input('ids');
        ProductType::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    public function inactive($data)
    {
        $ids = $data->input('ids');

        $products = ProductType::whereIn('id', $ids)->get();

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

        $products = ProductType::whereIn('id', $ids)->get();

        foreach ($products as $product) {
            $product->status = 1;
            $product->update();
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
