<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Category;

interface CategoryServiceInterface
{
    /**
     * Retrieve a category by its slug.
     *
     * @param string $slug
     * @return Category|null
     */
    public function getCategoryBySlug(string $slug): ?Category;
}
