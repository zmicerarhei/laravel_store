<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\BrandRepositoryInterface;

class BrandRepository implements BrandRepositoryInterface
{
    /**
     * @return Collection<int, Brand>
     */
    public function getAllBrands(): Collection
    {
        return Brand::all();
    }
}
