<?php

namespace domain\Services\ProductService;

use App\Models\Product;


class ProductService
{


    /**
     * __construct
     *
     * @return void
     */

    public function __construct()
    {
        $this->product = new Product();
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

    /**
     * Store
     * store data in database
     *
     * @param  array $data
     * @return void
     */
    public function store(array $data)
    {
        return $this->product->create($data);
    }

    /**
     * Get
     * retrieve relevant data using product_id
     *
     * @param  int  $product_id
     * @return void
     */
    public function get($product_id)
    {
        return $this->product->find($product_id);
    }

    /**
     * Update
     * update existing data using product_id
     *
     * @param  array $data
     * @param  int   $product_id
     * @return void
     */
    public function update(array $data, $product_id)
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
    protected function edit(Product $product, $data)
    {
        return array_merge($product->toArray(), $data);
    }

    /**
     * deleteSelected
     *
     * @param  mixed $data
     * @return void

    */

    public function deleteSelected($data)
    {
        $ids = $data->input('ids');
        Product::whereIn('id', $ids)->delete();

        return response()->json([
          'success' => true,
        ]);
    }

    /* * Delete
     * delete specific data using product_id
     *
     * @param  int  $product_id
     * @return void
     */
    public function delete(int $product_id)
    {
        return $this->product->find($product_id)->delete();
    }
}
