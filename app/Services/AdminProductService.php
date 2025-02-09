<?php

namespace App\Services;

use App\Contracts\AdminProductServiceInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Jobs\ExportAndSendReport;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AdminProductService implements AdminProductServiceInterface
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {
    }
    public function getAllProducts(): LengthAwarePaginator
    {
        $query = Product::with(Product::DEFAULT_RELATIONS);
        return $this->productRepository->getProducts($query, 8);
    }
    public function getDataForCreateView(): array
    {
        $brands = Brand::all();
        $categories = Category::all();
        $services = Service::all();
        return compact('services', 'brands', 'categories');
    }

    public function getDataForEditView(Product $product): array
    {
        $services = Service::all();
        $brands = Brand::all();
        $categories = Category::all();
        $product->load('services');
        $selectedServices = $product->services->pluck('id')->toArray();
        return compact('services', 'brands', 'categories', 'selectedServices', 'product');
    }
    public function addNewProduct(array $data): Product
    {
        return $this->productRepository->createProduct($data);
    }

    public function updateProduct(Product $product, array $data): bool
    {
        return $this->productRepository->updateProduct($product, $data);
    }

    public function deleteProduct(Product $product): ?bool
    {
        return $this->productRepository->deleteProduct($product);
    }

    public function syncServicesToProduct(Product $product, array $services): void
    {
        $product->services()->sync($services);
    }

    public function exportProductsToCsv(User $user): void
    {
        ExportAndSendReport::dispatch($user);
    }
}
