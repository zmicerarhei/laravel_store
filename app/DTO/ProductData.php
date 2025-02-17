<?php

namespace App\DTO;

use Spatie\LaravelData\Data;

class ProductData extends Data
{
    public function __construct(
        public string $name,
        public int $brand_id,
        public int $category_id,
        public string $description,
        public string $release_date,
        public float $price,
        public ?array $services = null
    ) {}
}
