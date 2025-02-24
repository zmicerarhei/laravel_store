<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\AdminProductServiceInterface;
use App\Contracts\BrandRepositoryInterface;
use App\Contracts\ProductFilterInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Jobs\ExportAndSendReport;
use App\Models\User;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\ServiceRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AdminProductService implements AdminProductServiceInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private CategoryRepository $categoryRepository,
        private BrandRepositoryInterface $brandRepository,
        private ServiceRepository $serviceRepository,
        private ProductFilterInterface $productFilter,
    ) {}
    public function getAllProducts(): LengthAwarePaginator
    {
        return $this->productRepository->getProductsWithFilters(
            null,
            null,
            Product::DEFAULT_RELATIONS,
            Product::ITEMS_PER_PAGE,
            $this->productFilter
        );
    }
    public function getDataForCreateView(): array
    {
        $services = $this->serviceRepository->getAllServices();
        $brands = $this->brandRepository->getAllBrands();
        $categories = $this->categoryRepository->getAllCategories();

        return compact('services', 'brands', 'categories');
    }

    public function getDataForEditView(Product $product): array
    {
        $services = $this->serviceRepository->getAllServices();
        $brands = $this->brandRepository->getAllBrands();
        $categories = $this->categoryRepository->getAllCategories();
        $product = $this->productRepository->getProductWithRelations($product->id, ['services']);
        $selectedServices = $product->services->pluck('id')->toArray();

        return compact('services', 'brands', 'categories', 'selectedServices', 'product');
    }

    public function exportProductsToCsv(User $user): void
    {
        $fields = config('reports.export_fields');
        ExportAndSendReport::dispatch($user, $fields);
    }
}
