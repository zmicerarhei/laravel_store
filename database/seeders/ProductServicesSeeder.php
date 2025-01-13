<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductServices;

class ProductServicesSeeder extends Seeder
{
    public function run(): void
    {
        $productServices = [
            ['product_id' => 1, 'service_id' => 1],
            ['product_id' => 1, 'service_id' => 2],
            ['product_id' => 2, 'service_id' => 1],
            ['product_id' => 2, 'service_id' => 2],
            ['product_id' => 2, 'service_id' => 3],
            ['product_id' => 3, 'service_id' => 1],
            ['product_id' => 3, 'service_id' => 2],
            ['product_id' => 3, 'service_id' => 3],
            ['product_id' => 3, 'service_id' => 4],
            ['product_id' => 4, 'service_id' => 1],
            ['product_id' => 4, 'service_id' => 2],
            ['product_id' => 4, 'service_id' => 3],
            ['product_id' => 5, 'service_id' => 1],
            ['product_id' => 5, 'service_id' => 2],
            ['product_id' => 5, 'service_id' => 4],
            ['product_id' => 6, 'service_id' => 1],
            ['product_id' => 6, 'service_id' => 2],
            ['product_id' => 6, 'service_id' => 3],
            ['product_id' => 7, 'service_id' => 1],
            ['product_id' => 7, 'service_id' => 2],
            ['product_id' => 7, 'service_id' => 3],
            ['product_id' => 8, 'service_id' => 1],
            ['product_id' => 8, 'service_id' => 2],
            ['product_id' => 8, 'service_id' => 3],
            ['product_id' => 9, 'service_id' => 1],
            ['product_id' => 9, 'service_id' => 2],
            ['product_id' => 10, 'service_id' => 1],
            ['product_id' => 10, 'service_id' => 2],
            ['product_id' => 11, 'service_id' => 1],
            ['product_id' => 11, 'service_id' => 2],
            ['product_id' => 12, 'service_id' => 1],
            ['product_id' => 12, 'service_id' => 2],
            ['product_id' => 13, 'service_id' => 1],
            ['product_id' => 13, 'service_id' => 2],
            ['product_id' => 14, 'service_id' => 1],
            ['product_id' => 14, 'service_id' => 2],
            ['product_id' => 15, 'service_id' => 1],
            ['product_id' => 15, 'service_id' => 2],
            ['product_id' => 16, 'service_id' => 1],
            ['product_id' => 16, 'service_id' => 2],
            ['product_id' => 17, 'service_id' => 1],
            ['product_id' => 17, 'service_id' => 2],
            ['product_id' => 18, 'service_id' => 1],
            ['product_id' => 18, 'service_id' => 2],
            ['product_id' => 19, 'service_id' => 1],
            ['product_id' => 19, 'service_id' => 2],
            ['product_id' => 20, 'service_id' => 1],
            ['product_id' => 20, 'service_id' => 2],
        ];

        foreach ($productServices as $item) {
            ProductServices::create($item);
        }
    }
}
