<?php

declare(strict_types=1);

namespace App\Contracts;


interface ExchangeRatesServiceInterface
{
    public function fetchExchangeRates(): array;
}
