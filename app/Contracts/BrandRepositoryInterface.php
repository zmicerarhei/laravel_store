<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Brand;

interface BrandRepositoryInterface
{
    /**
     * @return Collection<int, Brand>
     */
    public function getAllBrands(): Collection;
}
