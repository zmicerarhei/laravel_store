<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Filters\ProductFilter;
use App\Models\Product;
use App\Models\Category;
use App\Contracts\RepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository implements RepositoryInterface
{
    public function __construct(protected ProductFilter $productFilter) {}

    /**
     * Get products.
     *
     *  @return LengthAwarePaginator<Product>
     */
    public function getProducts(int $perPage, ?string $orderBy, string $category_slug): LengthAwarePaginator
    {
        /**
         * @var \Illuminate\Database\Eloquent\Builder<\App\Models\Product> $query
         */
        $query = $this->buildProductQuery($category_slug);
        $query->filter($this->productFilter);
        $this->applySorting($query, $orderBy);
        $products = $query->with(['brand', 'category'])->paginate($perPage);
        return $products;
    }

    public function createProduct(array $data): Product
    {
        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }

    public function deleteProduct(Product $product): void
    {
        $product->delete();
    }

    public function getRandomProducts(int $count)
    {
        $products = Product::inRandomOrder()->take($count)->get();
        return $products;
    }

    protected function buildProductQuery(string $category_slug): Builder
    {
        $query = Product::query();

        if ($category_slug !== 'all-categories') {
            $category = Category::where('slug', $category_slug)->firstOrFail();
            $query->where('category_id', $category->id);
        }

        return $query;
    }

    protected function applySorting(Builder $query, ?string $orderBy): void
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
