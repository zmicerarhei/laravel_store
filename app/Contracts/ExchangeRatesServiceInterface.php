<?php

declare(strict_types=1);

namespace App\Contracts;

interface ExchangeRatesServiceInterface
{
    /**
     *  Get exchange rates from API.
     *
     * @return array{rates:array<int, array{iso:string, sale:string}>}
     */
    public function fetchExchangeRates(): array;
}
