<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Filters\ProductFilter;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(protected ProductFilter $productFilter)
    {
    }

    /**
     * @return LengthAwarePaginator<Product>
     */
    public function getProducts(Builder $query, int $perPage): LengthAwarePaginator
    {
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
}
