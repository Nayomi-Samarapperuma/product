<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',

        'slug',
    ];

    /**
     * getWithSlug
     *
     * @param  string $slug
     * @return void
     */
    public function getWithSlug(string $slug)
    {
        return $this->where('slug', $slug)->get()->first();
    }
}
