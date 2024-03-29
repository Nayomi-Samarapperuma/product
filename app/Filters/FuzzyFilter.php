<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Spatie\QueryBuilder\Filters\Filter;

class FuzzyFilter implements Filter
{
    /**
     * @var array
     */
    private $columns;

    public function __construct(...$columns)
    {
        $this->columns = $columns;
    }

    public function __invoke(Builder $query, $value, string $property)
    {
        $attributes = $this->columns;

        $query->where(function (Builder $query) use ($attributes, $value) {
            foreach (Arr::wrap($attributes) as $attribute) {
                $query->orWhere(function ($query) use ($attribute, $value) {
                    foreach (explode(' ', $value) as $searchTerm) {
                        $query->where($attribute, 'LIKE', "%{$searchTerm}%");
                    }
                });
            }
        });

        return $this;
    }
}