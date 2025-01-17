<?php

namespace App\Filters;

use Filterable\Filter;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends Filter
{
    /**
     * Registered filters to operate upon.
     *
     * @var array<string>
     */
    protected array $filters = ['manufacturer'];

    /**
     * Filter the query by a given attribute value.
     *
     * @param string $value
     *
     * @return Builder
     */
    protected function manufacturer(string|array $value): Builder
    {
        if (is_array($value)) {
            return $this->builder->whereIn('manufacturer', $value);
        }
        return $this->builder->where('manufacturer', $value);
    }
}
