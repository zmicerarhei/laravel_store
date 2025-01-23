<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Sony'],
            ['name' => 'Huawei'],
            ['name' => 'Samsung'],
            ['name' => 'Apple'],
            ['name' => 'LG']
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
