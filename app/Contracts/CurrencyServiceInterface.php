<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Currency;

interface CurrencyServiceInterface
{
    /**
     *  Get exchange rates from API and save them to database.
     *
     *  @return void
     */
    public function updateExchangeRates(): void;

    /**
     *  Get all currencies
     *
     *  @return Collection<int, Currency>
     */
    public function getCurrencies(): Collection;

    /**
     *  Convert price according to currency
     *
     *  @param float $price
     *  @return float
     */
    public function convert(float $price): float;

    /**
     *  Set currency to session
     *
     *  @param string $iso
     *  @param float $rate
     *  @return void
     */
    public function setCurrencyToSession(string $iso, float $rate): void;
}
