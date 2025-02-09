<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    /**
     * Get all products.
     *  @param Builder $query
     *  @param int $perPage
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
     * @return bool
     */
    public function updateProduct(Product $product, array $data): bool;

    /**
     * Delete product.
     *
     * @param Product $product
     * @return bool|null
     */
    public function deleteProduct(Product $product): ?bool;

    /**
     * Get random products.
     *
     * @param int $count
     * @return Collection<Product>
     */
    public function getRandomProducts(int $count): Collection;
}
