<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function getCategoryBySlug(?string $slug): ?Category;
}
