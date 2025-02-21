<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\ProductRepositoryInterface;
use App\Contracts\ClientProductServiceInterface;
use App\Filters\ProductFilter;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ClientProductService implements ClientProductServiceInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private CategoryRepositoryInterface $categoryRepository,
        private ProductFilter $productFilter,
    ) {
    }

    public function getPaginatedProducts(
        int $perPage,
        ?string $orderBy,
        ?string $category_slug,
        array $relations
    ): LengthAwarePaginator {
        /**
         * @var \Illuminate\Database\Eloquent\Builder<\App\Models\Product> $query
         */
        $query = $this->buildProductQuery($category_slug);
        $query->filter($this->productFilter);
        $this->applySorting($query, $orderBy);
        $query->with($relations);
        $products = $this->productRepository->getProducts($query, $perPage);

        return $products;
    }

    public function generateAjaxResponse(LengthawarePaginator $products): string
    {
        return view('partials.products', compact('products'))->render();
    }

    /**
     * Builds the product query.
     *
     * @param string $category_slug
     * @return Builder<Product>
     *
     */
    private function buildProductQuery(?string $category_slug): Builder
    {
        $query = Product::query();

        if (isset($category_slug)) {
            $category = $this->categoryRepository->getCategoryBySlug($category_slug);
            $query->where('category_id', $category?->id);
        }

        return $query;
    }

    /**
     *  Applies sorting to the query.
     *
     * @param Builder<Product> $query
     * @param string|null $orderBy
     */
    private function applySorting(Builder $query, ?string $orderBy): void
    {
        $orderByConfig = match ($orderBy) {
            'price-low-high' => ['price', 'asc'],
            'price-high-low' => ['price', 'desc'],
            'name-a-z' => ['name', 'asc'],
            'name-z-a' => ['name', 'desc'],
            default => null,
        };

        if ($orderByConfig) {
            $query->orderBy(...$orderByConfig);
        }
    }
}
