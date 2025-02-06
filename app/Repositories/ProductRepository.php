<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Filters\ProductFilter;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(protected ProductFilter $productFilter) {}

    /**
     * Get products.
     *
     *  @return LengthAwarePaginator<Product>
     */
    public function getProducts($query, $perPage): LengthAwarePaginator
    {
        return $query->paginate($perPage);
    }

    public function createProduct(array $data): Product
    {
        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data): Product
    {
        $product->updateOrFail($data);
        return $product;
    }

    public function deleteProduct(Product $product): void
    {
        $product->delete();
    }

    public function getRandomProducts(int $count)
    {
        return Product::inRandomOrder()->take($count)->get();
    }
}
