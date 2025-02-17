<?php

declare(strict_types=1);

namespace App\Contracts;

interface BankApiClientInterface
{
    public function fetchExchangeRates(): string;
}
