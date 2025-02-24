<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Product;

interface ClientProductServiceInterface
{
    /**
     * Get paginated products.
     *
     * @param string $categorySlug
     * @param string|null $orderBy
     * @param array<string> $relations
     * @param int $perPage
     * @return LengthAwarePaginator<Product>
     */
    public function getPaginatedProducts(
        ?string $categorySlug,
        ?string $orderBy,
        array $relations,
        int $perPage,
    ): LengthAwarePaginator;

    /**
     * Generate ajax response.
     *
     * @param LengthAwarePaginator<Product> $products
     * @return string
     */
    public function generateAjaxResponse(LengthawarePaginator $products): string;
}
