<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\ProductRepositoryInterface;
use App\Contracts\ClientProductServiceInterface;
use App\Contracts\ProductFilterInterface;

class ClientProductService implements ClientProductServiceInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private ProductFilterInterface $productFilter,
    ) {
    }

    public function getPaginatedProducts(
        ?string $categorySlug,
        ?string $orderBy,
        array $relations,
        int $perPage,
    ): LengthAwarePaginator {

        return $this->productRepository->getProductsWithFilters(
            $categorySlug,
            $orderBy,
            $relations,
            $perPage,
            $this->productFilter,
        );
    }

    public function generateAjaxResponse(LengthawarePaginator $products): string
    {
        return view('partials.products', compact('products'))->render();
    }
}
