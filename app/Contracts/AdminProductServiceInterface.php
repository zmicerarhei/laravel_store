<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AdminProductServiceInterface
{
    /**
     * Retrieves all products.
     * @return LengthAwarePaginator<Product>
     */
    public function getAllProducts(): LengthAwarePaginator;

    /**
     * Retrieves the data for creating a view.
     *
     * @return array<string, mixed>
     */
    public function getDataForCreateView(): array;

    /**
     * Retrieves the data for editing a view.
     *
     * @return array<string, mixed>
     */
    public function getDataForEditView(Product $product): array;

    /**
     * Adds a new product.
     * @param array<string, mixed> $data
     * @return Product
     */
    public function addNewProduct(array $data): Product;

    /**
     * Updates a product.
     * @param Product $product
     * @param array<string, mixed> $data
     * @return bool
     */
    public function updateProduct(Product $product, array $data): bool;

    /**
     * Deletes a product.
     * @param Product $product
     * @return bool|null
     */
    public function deleteProduct(Product $product): ?bool;

    /**
     * Syncs services to a product.
     * @param Product $product
     * @param array<int, int> $services
     */
    public function syncServicesToProduct(Product $product, array $services): void;

    /**
     * Exports products to CSV.
     * @param User $user
     */
    public function exportProductsToCsv(User $user): void;
}
