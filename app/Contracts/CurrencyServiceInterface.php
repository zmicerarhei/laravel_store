<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface CurrencyServiceInterface
{
    public function updateExchangeRates(): void;

    public function getCurrencies(): Collection;

    public function convert(float $price): float;
}
