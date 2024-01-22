<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInventry extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'code',
        'date',
        'quantity',
        'reason',
    ];

    public function getAllInventries($product_id)
    {
        return $this->where('product_id', $product_id)->get();
    }


}
