<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\CurrencyRepositoryInterface;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    public function all(): Collection
    {
        return Currency::all();
    }

    public function save(array $rates): void
    {
        foreach ($rates as $rate) {
            Currency::updateOrCreate(
                ['iso' => $rate['iso']],
                [
                    'sale_rate' => $rate['sale'],
                    'is_main' => 0,
                ]
            );
        }
    }
}
