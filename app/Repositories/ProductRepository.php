<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\ProductFilterInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        private ProductFilterInterface $productFilter
    ) {
    }

    /**
     * Retrieves products with applied filters, ordering, and relations.
     *
     * @return LengthAwarePaginator<Product>
     */
    public function getProductsWithFilters(
        ?string $categorySlug,
        ?string $orderBy,
        array $relations,
        int $perPage,
    ): LengthAwarePaginator {
        $query = Product::query();

        if ($categorySlug) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $query->filter($this->productFilter);

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

        $query->with($relations);

        return $query->paginate($perPage);
    }

    public function createProduct(array $data): Product
    {
        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data): bool
    {
        return $product->updateOrFail($data);
    }

    public function deleteProduct(Product $product): ?bool
    {
        return $product->delete();
    }

    public function getRandomProducts(int $count): Collection
    {
        return Product::inRandomOrder()->take($count)->get();
    }

    public function getProductWithRelations(int $id, array $relations): Product
    {
        return Product::with($relations)->findOrFail($id);
    }

    public function syncProductToServices(Product $product, array $services): void
    {
        $product->services()->sync($services);
    }


    public function getAllProducts($columns = ['*']): Collection
    {
        return Product::all($columns);
    }

    public function getServicesByProductId(int $id): ?Collection
    {
        return Product::find($id)?->services;
    }
}
