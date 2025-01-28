<?php

declare(strict_types=1);

namespace App\Contracts;

interface CurrencyServiceInterface
{
    public function fetchExchangeRates(): void;

    public function convert(float $price): float;
}
