<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryServiceInterface
{
    public function getCategoryBySlug(string $slug): ?Category;
}
