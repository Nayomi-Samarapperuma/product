<?php

namespace domain\Services\PurchasingDataService;

//use App\Models\ProductVendor;
use App\Models\PurchasingData;

class PurchasingDataService
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->purchasingData = new PurchasingData();
        // $this->productVendor = new ProductVendor();
    }

    /**
     * UpdatePurchasing
     * update existing data using product_id
     *
     * @param  array $data
     * @param  int   $product_id
     * @return void
     */
    public function updatePurchasing(array $data, int $product_id)
    {
        $purchasingData = $this->purchasingData->getPurchasingData($product_id);
        if ($purchasingData) {
            $data['uom'] = $data['unit_of_measure_id'];
            return $purchasingData->update($this->edit($purchasingData, $data));
        } else {
            $data['product_id'] = $product_id;
            $data['uom'] = $data['unit_of_measure_id'];
            return $this->purchasingData->create($data);
        }
    }

    

    /**
     * Edit
     * merge data which retrieved from update function as an array
     *
     * @param  mixed $purchasingData
     * @param  mixed $data
     * @return void
     */
    public function edit(PurchasingData $purchasingData, $data)
    {
        return array_merge($purchasingData->toArray(), $data);
    }

    /**
     * GetAllAssignedVendors
     * retrieve relevant data using productId
     *
     * @param  int  $productId
     * @return void
     */
    // public function getAllAssignedVendors(int $productId)
    // {
    //     return $this->productVendor->getAllAssignedVendors($productId);
    // }

    /**
     * StoreAssignedVendors
     * store data in database
     *
     * @param  array $data
     * @return void
     */
    // public function storeAssignedVendors(array $data)
    // {
    //     $this->productVendor->removeDefault($data['product_id']);
    //     // $defaultVendor = $this->productVendor->getDefaultVendor($data['product_id']);
    //     // if(!$defaultVendor){
    //     //     $data['is_default'] = 1;
    //     // }
    //     $data['is_default'] = 1;
    //     $this->productVendor->create($data);
    // }

    /**
     * DeleteAssignedVendor
     * delete specific data using id
     *
     * @param  int  $id
     * @return void
     */
    // public function deleteAssignedVendor(int $id)
    // {
    //     $vendor =  $this->productVendor->find($id);
    //     $vendor->delete();
    // }

    public function getPurchasingData($productId)
    {
        return $this->purchasingData->getPurchasingData($productId);
    }
}
