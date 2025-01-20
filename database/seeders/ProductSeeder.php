<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Телевизор Sony R11',
                'description' => 'Телевизор с высоким разрешением и смарт-функциями.',
                'release_date' => '2024-01-01',
                'price' => 99.99,
                'link' => '/images/product_1.jpg',
                'category_id' => 1,
                'brand_id' => 1,
            ],
            [
                'name' => 'Смартфон Sony P20',
                'description' => 'Современный смартфон с мощным процессором и большим объемом памяти.',
                'release_date' => '2024-01-02',
                'price' => 85.50,
                'link' => '/images/product_2.jpg',
                'category_id' => 2,
                'brand_id' => 1,
            ],
            [
                'name' => 'Смартфон Sony S15',
                'description' => 'Современный смартфон с мощным процессором и большим объемом памяти.',
                'release_date' => '2024-01-02',
                'price' => 85.50,
                'link' => '/images/product_2.jpg',
                'category_id' => 2,
                'brand_id' => 1,
            ],
            [
                'name' => 'Смартфон Sony S14',
                'description' => 'Современный смартфон с мощным процессором и большим объемом памяти.',
                'release_date' => '2024-01-02',
                'price' => 85.50,
                'link' => '/images/product_2.jpg',
                'category_id' => 2,
                'brand_id' => 1,
            ],
            [
                'name' => 'Телевизор Huawei 2214',
                'description' => 'Телевизор с высоким разрешением и смарт-функциями.',
                'release_date' => '2024-01-03',
                'price' => 75.00,
                'link' => '/images/product_3.jpg',
                'category_id' => 1,
                'brand_id' => 2,
            ],
            [
                'name' => 'Ноутбук Huawei Slim',
                'description' => 'Супер мощный ноутбук для работы и игр.',
                'release_date' => '2024-01-12',
                'price' => 49.99,
                'link' => '/images/product_4.jpg',
                'category_id' => 3,
                'brand_id' => 2,
            ],
            [
                'name' => 'Планшет Huawei 1521',
                'description' => 'Легкий и портативный планшет для работы и игр.',
                'release_date' => '2024-01-05',
                'price' => 299.99,
                'link' => '/images/product_5.jpg',
                'category_id' => 2,
                'brand_id' => 2,
            ],
            [
                'name' => 'Холодильник Huawei 225',
                'description' => 'Современный двухкамерный холодильник',
                'release_date' => '2024-01-06',
                'price' => 499.99,
                'link' => '/images/product_6.jpg',
                'category_id' => 1,
                'brand_id' => 2,
            ],
            [
                'name' => 'Пылесос Samsung 1882',
                'description' => 'Пылесос мощный с функцией мойки.',
                'release_date' => '2024-01-07',
                'price' => 199.99,
                'link' => '/images/product_7.jpg',
                'category_id' => 1,
                'brand_id' => 3,
            ],
            [
                'name' => 'Микроволновая печь Samsung A8',
                'description' => 'Современная микроволновая печь с грилем.',
                'release_date' => '2024-01-08',
                'price' => 150.00,
                'link' => '/images/product_8.jpg',
                'category_id' => 1,
                'brand_id' => 3,
            ],
            [
                'name' => 'Стиральная машина Samsung 1132',
                'description' => 'Автоматическая стиральная машина с функцией сушки.',
                'release_date' => '2024-01-09',
                'price' => 400.00,
                'link' => '/images/product_9.jpg',
                'category_id' => 1,
                'brand_id' => 3,
            ],
            [
                'name' => 'Ноутбук Samsung 2618',
                'description' => 'Мощный современный ноутбук с большим количеством памяти',
                'release_date' => '2024-01-10',
                'price' => 159.99,
                'link' => '/images/product_10.jpg',
                'category_id' => 3,
                'brand_id' => 3,
            ],
            [
                'name' => 'Игровая консоль Apple',
                'description' => 'Портативная игровая консоль с поддержкой облачного гейминга.',
                'release_date' => '2024-01-11',
                'price' => 299.99,
                'link' => '/images/product_1.jpg',
                'category_id' => 2,
                'brand_id' => 4,
            ],
            [
                'name' => 'Телевизор Apple 2000',
                'description' => 'Новейший телевизор с качественной матрицей',
                'release_date' => '2024-01-11',
                'price' => 99.99,
                'link' => '/images/product_2.jpg',
                'category_id' => 1,
                'brand_id' => 4,
            ],
            [
                'name' => 'Ноутбук Apple 2115',
                'description' => 'Мощный современный ноутбук с большим количеством памяти',
                'release_date' => '2024-01-10',
                'price' => 159.99,
                'link' => '/images/product_10.jpg',
                'category_id' => 2,
                'brand_id' => 4,
            ],
            [
                'name' => 'Компьютер Apple i7',
                'description' => 'Мощный современный компьютер с большим количеством памяти и хорошей видеокартой',
                'release_date' => '2024-01-10',
                'price' => 159.99,
                'link' => '/images/product_10.jpg',
                'category_id' => 3,
                'brand_id' => 4,
            ],
            [
                'name' => 'Стиральная машина LG 1253',
                'description' => 'Автоматическая стиральная машина с функцией сушки.',
                'release_date' => '2024-01-09',
                'price' => 400.00,
                'link' => '/images/product_9.jpg',
                'category_id' => 1,
                'brand_id' => 5,
            ],
            [
                'name' => 'Игровая консоль LG 15',
                'description' => 'Портативная игровая консоль с поддержкой облачного гейминга.',
                'release_date' => '2024-01-11',
                'price' => 299.99,
                'link' => '/images/product_1.jpg',
                'category_id' => 2,
                'brand_id' => 5,
            ],
            [
                'name' => 'Телевизор LG 18',
                'description' => 'Новейший телевизор с качественной матрицей',
                'release_date' => '2024-01-11',
                'price' => 99.99,
                'link' => '/images/product_2.jpg',
                'category_id' => 1,
                'brand_id' => 5,
            ],
            [
                'name' => 'Ноутбук LG New',
                'description' => 'Мощный современный ноутбук с большим количеством памяти',
                'release_date' => '2024-01-10',
                'price' => 159.99,
                'link' => '/images/product_10.jpg',
                'category_id' => 3,
                'brand_id' => 5,
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
