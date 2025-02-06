<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\CategoryServiceInterface;
use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryService implements CategoryServiceInterface
{
    public function __construct(private CategoryRepository $categoryRepository) {}

    public function getCategoryBySlug(string $slug): ?Category
    {
        return $slug !== 'all-categories' ? $this->categoryRepository->getCategoryBySlug($slug)  : null;
    }
}
