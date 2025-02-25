<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Service;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    /**
     * Get sorted and filtered products taking into account pagination.
     *
     * @param string|null $categorySlug
     * @param string|null $orderBy
     * @param array<string> $relations
     * @param int $perPage
     * @return LengthAwarePaginator<Product>
     */
    public function getProductsWithFilters(
        ?string $categorySlug,
        ?string $orderBy,
        array $relations,
        int $perPage,
        ProductFilterInterface $productFilter,
    ): LengthAwarePaginator;

    /**
     * Get all products.
     *
     * @param array<string> $columns
     * @return Collection<int, Product>
     */
    public function getAllProducts($columns = ['*']): Collection;

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

    /**
     * Retrieves the services for a given product ID.
     *
     * @param int $id The ID of the product.
     * @return Collection<int, Service>
     */
    public function getServicesByProductId(int $id): ?Collection;
}
