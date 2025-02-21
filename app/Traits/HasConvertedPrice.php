<?php

namespace App\Traits;

trait HasConvertedPrice
{
    /**
     *  Convert price according to the selected currency
     *
     *  @return float
     */
    public function getConvertedPriceAttribute(): float
    {
        return round($this->price / session('sale_rate', 1), 2);
    }
}
