<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{

    public function __construct() {}

    public function getCategoryBySlug($slug)
    {
        return Category::where('slug', $slug)->firstOrFail();
    }
}
