<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    /**
     * Get all products.
     *
     *  @return LengthAwarePaginator<Product>
     */
    public function getProducts(int $perPage, string $orderBy, string $category): LengthAwarePaginator;

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
