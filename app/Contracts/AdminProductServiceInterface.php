<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Product;

interface AdminProductServiceInterface
{
    public function getAllProducts();

    public function getDataForCreateView();

    public function addNewProduct(array $data);

    public function syncServicesToProduct(Product $product, array $services);

    // public function deleteProduct(Product $product);

    // public function updateProduct(Product $product, array $data);

    // public function exportProductsToCsv();
}
