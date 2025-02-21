<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\AdminProductServiceInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Jobs\ExportAndSendReport;
use App\Models\User;
use App\Models\Product;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ServiceRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AdminProductService implements AdminProductServiceInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private CategoryRepository $categoryRepository,
        private BrandRepository $brandRepository,
        private ServiceRepository $serviceRepository
    ) {
    }
    public function getAllProducts(): LengthAwarePaginator
    {
        $query = Product::with(Product::DEFAULT_RELATIONS);

        return $this->productRepository->getProducts($query, Product::ITEMS_PER_PAGE);
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
        ExportAndSendReport::dispatch($user);
    }
}
