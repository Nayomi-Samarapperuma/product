<?php

namespace domain\Services\VendorDataService;

use App\Models\ProductVendor;
use App\Models\VendorData;

class VendorDataService
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->vendorData = new VendorData();
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
    // public function updateVendor(array $data, int $product_id)
    // {
    //     $vendorData = $this->vendorData->getVendorData($product_id);
    //     if ($vendorData) {
    //         $data['uom'] = $data['unit_of_measure_id'];
    //         return $vendorData->update($this->edit($vendorData, $data));
    //     } else {
    //         $data['product_id'] = $product_id;
    //         $data['uom'] = $data['unit_of_measure_id'];
    //         return $this->vendorData->create($data);
    //     }
    // }

    /**
     * store
     *
     * @param  mixed $data
     * @return void
     */
    public function store(array $data)
    {
        return $this->vendorData->create($data);
    }

    /**
     * Edit
     * merge data which retrieved from update function as an array
     *
     * @param  mixed $purchasingData
     * @param  mixed $data
     * @return void
     */
    public function edit(VendorData $vendorData, $data)
    {
        return array_merge($vendorData->toArray(), $data);
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

    public function getVendorData($productId)
    {
        return $this->vendorData->getVendorData($productId);
    }

    /**
     * Delete
     * delete specific data using vendor_id
     *
     * @param  int  $vendor_id
     * @return void
     */
    public function delete(int $vendor_id)
    {
        return $this->vendorData->find($vendor_id)->delete();
    }
}
