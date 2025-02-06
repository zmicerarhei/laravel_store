<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

interface ProductRepositoryInterface
{
    /**
     * Get all products.
     *
     *  @return LengthAwarePaginator<Product>
     */
    public function getProducts(Builder $query, int $perPage): LengthAwarePaginator;

    /**
     * Create product.
     *
     * @param array<string, mixed> $data
     * @return Product
     */
    public function createProduct(array $data): Product;

    /**
     * Update product.
     *
     * @param Product $product
     * @param array<string, mixed> $data
     * @return Product
     */
    public function updateProduct(Product $product, array $data): Product;

    /**
     * Delete product.
     *
     * @param Product $product
     * @return void
     */
    public function deleteProduct(Product $product): void;
}
