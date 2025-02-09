<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function __construct()
    {
    }

    /**
     * Retrieve a category by its slug.
     *
     * @param string $slug The slug of the category.
     * @return Category The category instance matching the slug.
     */
    public function getCategoryBySlug($slug)
    {
        return Category::where('slug', $slug)->firstOrFail();
    }
}
