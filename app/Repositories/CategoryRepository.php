<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function __construct() {}

    public function getAllCategories(): Collection
    {
        return Category::all();
    }

    /**
     * Retrieve a category by its slug.
     *
     * @param string $slug The slug of the category.
     * @return Category The category instance matching the slug.
     */
    public function getCategoryBySlug(?string $slug): ?Category
    {
        return Category::where('slug', $slug)->first();
    }
}
