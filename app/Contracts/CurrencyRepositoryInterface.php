<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Currency;

interface CurrencyRepositoryInterface
{
    /**
     * @return Collection<int, Currency>
     *
     */
    public function all(): Collection;

    /**
     * @param array<string> $rate
     * @param string $iso
     *
     */
    public function updateByIso(array $rate, string $iso): void;
}
