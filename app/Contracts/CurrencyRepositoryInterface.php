<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Support\Collection;

interface CurrencyRepositoryInterface
{
    public function all(): Collection;
    public function updateByIso(array $rate, string $iso): void;
}
