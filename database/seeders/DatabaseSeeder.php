<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(CategorySeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(ProductsServicesSeeder::class);
        $this->call(CurrencySeeder::class);
    }
}
