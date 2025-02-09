<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ClientProductServiceInterface
{
    /**
     * Get paginated products.
     *
     * @param int $perPage
     * @param string|null $orderBy
     * @param string $category_slug
     * @param array<string> $relations
     * @return LengthAwarePaginator<Product>
     */
    public function getPaginatedProducts(
        int $perPage,
        ?string $orderBy,
        string $category_slug,
        array $relations,
    ): LengthAwarePaginator;

    public function getRandomProducts(int $count): Collection;

    public function updatePrices(Product $product): void;

    public function generateAjaxResponse(LengthawarePaginator $product): string;
}
