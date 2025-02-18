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
