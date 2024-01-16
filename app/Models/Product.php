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
        'name',
        'description',
        'price',
        'category',
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

    public function getPurchaseUopNameAttribute()
     {
         return $this->purchaseUopData ? $this->purchaseUopData->name : 'N/A';
     }

    public function getStockUopNameAttribute()
    {
        return $this->stockUopData ? $this->stockUopData->name : 'N/A';
     }

     public function getTypeNameAttribute()
     {
         return $this->typeData? $this->typeData->name : 'N/A';
     }
     public function getCategoryNameAttribute()
     {
         return $this->categoryData? $this->categoryData->name : 'N/A';
     }
     public function getPurchaseUomIdAttribute()
     {
         return $this->purchaseUopData? $this->purchaseUopData->id : null;
     }
     public function getStockUopIdAttribute()
     {
         return $this->stockUopData? $this->stockUopData->id : null;
     }
     public function getTypeIdAttribute()
     {
         return $this->typeData? $this->typeData->id : null;
     }
     public function getCategoryIdAttribute()
     {
         return $this->categoryData? $this->categoryData->id : null;
     }
     public function purchaseUop()
     {
         return $this->belongsTo(Uop::class, 'purchase_uop_id', 'id');
     }
     public function stockUom()
     {
         return $this->belongsTo(Uop::class,'stock_uop_id', 'id');
     }
     public function type()
     {
         return $this->belongsTo(Type::class, 'type_id', 'id');
     }
     public function category()
     {
         return $this->belongsTo(Category::class, 'category_id', 'id');
     }

}

