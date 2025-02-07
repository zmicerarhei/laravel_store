<?php

namespace App\Services;

use App\Contracts\AdminProductServiceInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Service;

class AdminProductService implements AdminProductServiceInterface
{
    public function __construct(private ProductRepositoryInterface $productRepository) {}
    public function getAllProducts()
    {
        $query = Product::with(['category', 'brand']);
        return $this->productRepository->getProducts($query, 8);
    }
    public function getDataForCreateView()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $services = Service::all();
        return compact('services', 'brands', 'categories');
    }
    public function addNewProduct(array $data): Product
    {
        return $this->productRepository->createProduct($data);
    }

    public function syncServicesToProduct(Product $product, array $services): void
    {
        $product->services()->sync($services);
    }
}
