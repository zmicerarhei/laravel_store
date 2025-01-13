<?php

declare(strict_types=1);

namespace App\Services;

use App\Filters\ProductFilter;
use App\Models\Product;
use App\Models\Category;
use App\Services\Interfaces\ServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class ProductService implements ServiceInterface
{
    protected $productFilter;

    public function __construct(ProductFilter $productFilter)
    {
        $this->productFilter = $productFilter;
    }

    public function getProducts(int $perPage, ?string $orderBy, string $category_slug): array
    {
        $query = Product::query();

        if ($category_slug !== 'all-categories') {
            $category = Category::where('slug', $category_slug)->firstOrFail();
            $query->where('category_id', $category->id);
        }

        $baseQuery = clone $query;

        $query->filter($this->productFilter);
        $this->applySorting($query, $orderBy);

        $filters = $this->getUniqueFiltersCheckboxes($baseQuery, ['manufacturer']);
        $total = $query->count();
        $products = $query->paginate($perPage);
        return [
            'products' => $products,
            'filters' => $filters,
            'total' => $total
        ];
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

    protected function getUniqueFiltersCheckboxes($query, $fields): array
    {

        $filtersCheckboxes = [];
        foreach ($fields as $field) {
            $cloneQuery = clone $query;
            $filtersCheckboxes[$field] = $cloneQuery->select($field)->distinct()->pluck($field)->toArray();
        }
        return $filtersCheckboxes;
    }

    protected function applySorting($query, $orderBy): void
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
