<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\BrandRepositoryInterface;

class BrandRepository implements BrandRepositoryInterface
{
    public function __construct() {}

    public function getAllBrands(): Collection
    {
        return Brand::all();
    }
}
