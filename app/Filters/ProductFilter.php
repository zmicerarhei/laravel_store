<?php

namespace App\Filters;

use App\Models\Product;
use Filterable\Filter;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends Filter
{
    /**
     * Registered filters to operate upon.
     *
     * @var array<string>
     */
    protected array $filters = ['brand'];

    /**
     * Filter the query by a given attribute value.
     *
     * @param string|array<string> $value
     *
     * @return Builder<Product>
     */
    protected function brand(string|array $value): Builder
    {
        return $this->builder->whereHas('brand', function (Builder $query) use ($value) {
            if (is_array($value)) {
                $query->whereIn('name', $value);
            } else {
                $query->where('name', $value);
            }
        });
    }
}
