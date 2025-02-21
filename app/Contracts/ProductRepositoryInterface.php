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
     *  @param Builder<Product> $query
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
     * @return Collection<int, Product>
     */
    public function getRandomProducts(int $count): Collection;

    /**
     * Get product with relations.
     *
     * @param int $id
     * @param array<string> $relations
     * @return Product
     */
    public function getProductWithRelations(int $id, array $relations): Product;

    /**
     * Sync product to services.
     *
     * @param Product $product
     * @param array<int> $services
     * @return void
     */
    public function syncProductToServices(Product $product, array $services): void;
}
