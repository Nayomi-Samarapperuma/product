<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'color',
        'name',
        'barcode',
        'description',
        'cost',
        'selling_price',
        'purchase_uop',
        'stock_uop',
        'type',
        'image',
        'size_width',
        'size_height',
        'size_length',
        'gross_weight',
        'net_weight',
        'uom_weight',
        'category',

        'size',
        'category_l1_id',
        'hs_code',
        'rol',
    ];

    protected $appends = [
        'purchase_uop_name',
        'stock_uop_name',
        'type_name',
        'category_name',
    ];




    public function consignment()
    {
        return $this->hasOne(ConsignmentItem::class, 'item_id', 'id');
    }

    public function productSize()
    {
        return $this->hasOne(ProductSize::class, 'slug', 'size');
    }

    /**
     * purchase_uom
     *
     * @return void
     */
    public function purchaseUomData()
    {
        return $this->hasOne(UnitOfMeasure::class, 'id', 'purchase_uom');
    }

    /**
     * stock_uom
     *
     * @return void
     */
    public function stockUomData()
    {
        return $this->hasOne(UnitOfMeasure::class, 'id', 'stock_uom');
    }

    /**
     * type
     *
     * @return void
     */
    public function typeData()
    {
        return $this->hasOne(ProductType::class, 'id', 'type');
    }

    /**
     * categoryData
     *
     * @return void
     */
    public function categoryData()
    {
        return $this->hasOne(ProductCategory::class, 'id', 'category');
    }

    public function getVendorAttribute()
    {
        return $this->consignment ? $this->consignment->vendor : 'N/A';
    }

    public function getVendorIdAttribute()
    {
        return $this->consignment ? $this->consignment->vendor_id : 'N/A';
    }

    public function getPercentageAttribute()
    {
        return $this->consignment ? $this->consignment->percentage : 'N/A';
    }

    /**
     * getPurchaseUomNameAttribute
     *
     * @return void
     */
    public function getPurchaseUomNameAttribute()
    {
        return $this->purchaseUomData ? $this->purchaseUomData->name : 'N/A';
    }

    /**
     * getStockUomNameAttribute
     *
     * @return void
     */
    public function getStockUomNameAttribute()
    {
        return $this->stockUomData ? $this->stockUomData->name : 'N/A';
    }

    /**
     * getTypeNameAttribute
     *
     * @return void
     */
    public function getTypeNameAttribute()
    {
        return $this->typeData ? $this->typeData->name : 'N/A';
    }

    /**
     * getCategoryNameAttribute
     *
     * @return void
     */
    public function getCategoryNameAttribute()
    {
        return $this->categoryData ? $this->categoryData->full_name : 'N/A';
    }

    public function getSizeNameAttribute()
    {
        return $this->productSize ? $this->productSize->name : 'N/A';
    }

    public function images()
    {
        return $this->hasOne(Image::class, 'id', 'image');
    }

    public function getImageUrlAttribute()
    {
        return $this->images ? $this->images->name : 'N/A';
    }

    /**
     * getFormateCostAttribute
     *
     * @return void
     */
    public function getFormateCostAttribute()
    {
        $cost = $this->cost;
        return number_format($cost, 3);
    }

    public function getFormateSellingPriceAttribute()
    {
        $selling_price = $this->selling_price;
        return number_format($selling_price, 3);
    }

    public function getNameWithDescriptionAttribute()
    {
        return $this->name . ' - ' . $this->description;
    }

    public function productCosting()
    {
        return $this->hasMany(ProductCosting::class, 'product_id', 'id');
    }

    public function getproductForBom()
    {
        return $this->whereHas('typeData', function ($query) {
            $query->where('type', 'finish-good')->orWhere('type', 'semi-finish-good');
        })->get();
    }

    public function getFinishGood()
    {
        return $this->whereHas('typeData', function ($query) {
            $query->where('type', 'finish-good');
        })->get();
    }

    public function stockAvailable()
    {
        return $this->hasMany(Stock::class, 'product_id', 'id')->where('qty', '>', 0);
    }

    public function getStockQtyAttribute()
    {
        return $this->hasMany(Stock::class, 'product_id', 'id')->sum('qty');
    }

    public function getProductForMr()
    {
        return $this->whereHas('stockAvailable', function (Builder $query) {
            $query->whereHas('bin', function (Builder $query) {
                $query->where('stock_remove', 1)->orWhere('stock_putaway', 1);
            });
        })->get();
    }

    public function stockProducts()
    {
        return $this->hasMany(Stock::class, 'product_id', 'id');
    }

    public function getProductForStock()
    {
        return $this->whereHas('stockProducts', function (Builder $query) {
            // $query->where('qty', '>', 0);
        })->get();
        // return $this->whereHas('stockProducts')->get();
    }

    public function getProductForGi()
    {
        return $this->whereHas('stockProducts', function (Builder $query) {
            // $query->where('status', 1);
        })->get();
        // return $this->whereHas('stockProducts')->get();
    }

    // public function getProductForGT($warehouse_id)
    // {
    //     return $this->whereHas('stockProducts', function (Builder $query) use($warehouse_id) {
    //         $query->where('warehouse_id', $warehouse_id);
    //     })->get();
    // }

    public function getByCode($barcode)
    {
        return $this->where('barcode',$barcode)->first();
    }


}

