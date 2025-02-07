<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ClientProductServiceInterface
{
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
