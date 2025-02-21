<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\CurrencyRepositoryInterface;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    /**
     * @return Collection<int, Currency>
     *
     */
    public function all(): Collection
    {
        return Currency::all();
    }

    public function updateByIso(array $rate, string $iso): void
    {
        Currency::updateOrCreate(
            ['iso' => $iso],
            [
                'sale_rate' => $rate['sale'],
                'is_main' => 0,
            ]
        );
    }
}
