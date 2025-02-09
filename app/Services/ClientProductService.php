<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\CurrencyServiceInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Contracts\ClientProductServiceInterface;
use App\Filters\ProductFilter;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ClientProductService implements ClientProductServiceInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private ProductFilter $productFilter,
        private CurrencyServiceInterface $currencyService
    ) {
    }

    public function getPaginatedProducts(
        int $perPage,
        ?string $orderBy,
        string $category_slug,
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
        foreach ($products->items() as $product) {
            $product->price = $this->currencyService->convert((float)$product->price);
        };
        return $products;
    }

    public function getRandomProducts(int $count): Collection
    {
        return Product::inRandomOrder()->take($count)->get();
    }

    public function updatePrices(Product $product): void
    {
        foreach ($product->services as $service) {
            /** @var \App\Models\Service $service */
            $service->price = $this->currencyService->convert((float)$service->price);
        }

        $product->price = $this->currencyService->convert((float)$product->price);
    }

    /**
     * @param LengthAwarePaginator<Product> $products
     * @return string
     */
    public function generateAjaxResponse(LengthawarePaginator $products): string
    {
        return view('partials.products', compact('products'))->render();
    }

    private function buildProductQuery(string $category_slug): Builder
    {
        $query = Product::query();

        if ($category_slug !== 'all-categories') {
            $category = Category::where('slug', $category_slug)->firstOrFail();
            $query->where('category_id', $category->id);
        }

        return $query;
    }

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
